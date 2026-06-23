<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\DepartureSchedule;
use App\Models\Feature;
use App\Models\HeroSetting;
use App\Models\LandingPage;
use App\Models\Package;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicHomeController extends Controller
{
    /**
     * Display the public homepage with full caching, custom-domain detection,
     * and server-side SEO schema generation.
     */
    public function index(Request $request): Response|View|RedirectResponse
    {
        // 1. Dynamic Domain Masking — guard against empty host matching empty custom_domain
        $host = $request->getHost();
        if (! empty($host)) {
            $customPage = LandingPage::where('custom_domain', $host)
                ->where('is_active', true)
                ->first();
            if ($customPage) {
                try {
                    return app(PublicLandingPageController::class)->show($customPage->slug);
                } catch (ModelNotFoundException $e) {
                    // Fallback to normal homepage if the page is no longer accessible
                }
            }
        }

        // 2. Cache all homepage queries for 5 minutes (TTL = 300 seconds)
        $hero = Cache::remember('homepage_hero', 300, fn () => HeroSetting::first());
        $features = Cache::remember('homepage_features', 300, fn () => Feature::orderBy('order')->get());

        try {
            $packages = Cache::remember('homepage_packages', 300, fn () => Package::where('is_active', true)->get());
            if (! ($packages instanceof Collection) || ($packages->isNotEmpty() && ! ($packages->first() instanceof Package))) {
                throw new \RuntimeException('Stale packages cache');
            }
        } catch (\Throwable $e) {
            Cache::forget('homepage_packages');
            $packages = Package::where('is_active', true)->get();
        }

        try {
            $schedules = Cache::remember('homepage_schedules', 300, fn () => DepartureSchedule::with('package')
                ->where('is_active', true)
                ->where('departure_date', '>=', now()->startOfDay())
                ->orderBy('departure_date', 'asc')
                ->get());
            if (! ($schedules instanceof Collection) || ($schedules->isNotEmpty() && ! ($schedules->first() instanceof DepartureSchedule))) {
                throw new \RuntimeException('Stale schedules cache');
            }
        } catch (\Throwable $e) {
            Cache::forget('homepage_schedules');
            $schedules = DepartureSchedule::with('package')
                ->where('is_active', true)
                ->where('departure_date', '>=', now()->startOfDay())
                ->orderBy('departure_date', 'asc')
                ->get();
        }

        try {
            $registrationPackages = Cache::remember('homepage_registration_packages', 300, fn () => Package::where('is_active', true)->get());
            if (! ($registrationPackages instanceof Collection) || ($registrationPackages->isNotEmpty() && ! ($registrationPackages->first() instanceof Package))) {
                throw new \RuntimeException('Stale registration packages cache');
            }
        } catch (\Throwable $e) {
            Cache::forget('homepage_registration_packages');
            $registrationPackages = Package::where('is_active', true)->get();
        }

        try {
            $registrationSchedules = Cache::remember('homepage_registration_schedules', 300, fn () => DepartureSchedule::where('is_active', true)
                ->where('available_seats', '>', 0)
                ->whereDate('departure_date', '>=', now())
                ->orderBy('departure_date', 'asc')
                ->get());
            if (! ($registrationSchedules instanceof Collection) || ($registrationSchedules->isNotEmpty() && ! ($registrationSchedules->first() instanceof DepartureSchedule))) {
                throw new \RuntimeException('Stale registration schedules cache');
            }
        } catch (\Throwable $e) {
            Cache::forget('homepage_registration_schedules');
            $registrationSchedules = DepartureSchedule::where('is_active', true)
                ->where('available_seats', '>', 0)
                ->whereDate('departure_date', '>=', now())
                ->orderBy('departure_date', 'asc')
                ->get();
        }

        try {
            $testimonials = Cache::remember('homepage_testimonials', 300, fn () => Testimonial::all());
            if (! ($testimonials instanceof Collection) || ($testimonials->isNotEmpty() && ! ($testimonials->first() instanceof Testimonial))) {
                throw new \RuntimeException('Stale testimonials cache');
            }
        } catch (\Throwable $e) {
            Cache::forget('homepage_testimonials');
            $testimonials = Testimonial::all();
        }

        try {
            $articles = Cache::remember('homepage_articles', 300, fn () => Article::where('status', 'published')->orderBy('created_at', 'desc')->take(3)->get());
            if (! ($articles instanceof Collection) || ($articles->isNotEmpty() && ! ($articles->first() instanceof Article))) {
                throw new \RuntimeException('Stale articles cache');
            }
        } catch (\Throwable $e) {
            Cache::forget('homepage_articles');
            $articles = Article::where('status', 'published')->orderBy('created_at', 'desc')->take(3)->get();
        }

        $settings = Cache::remember('homepage_settings', 300, fn () => SiteSetting::pluck('value', 'key')->toArray());

        try {
            $faqs = Cache::remember('homepage_faqs', 300, fn () => \App\Models\Faq::where('is_active', true)->orderBy('order', 'asc')->get());
            if (! ($faqs instanceof Collection) || ($faqs->isNotEmpty() && ! ($faqs->first() instanceof \App\Models\Faq))) {
                throw new \RuntimeException('Stale faqs cache');
            }
        } catch (\Throwable $e) {
            Cache::forget('homepage_faqs');
            $faqs = \App\Models\Faq::where('is_active', true)->orderBy('order', 'asc')->get();
        }

        // Guard: if cache returned stale/corrupt data (hero has no try-catch above)
        if (! ($hero instanceof HeroSetting)) {
            Cache::forget('homepage_hero');
            $hero = HeroSetting::first();
        }
        if (! ($features instanceof Collection) || ($features->isNotEmpty() && ! ($features->first() instanceof Feature))) {
            Cache::forget('homepage_features');
            $features = Feature::orderBy('order')->get();
        }
        if (! is_array($settings)) {
            Cache::forget('homepage_settings');
            $settings = SiteSetting::pluck('value', 'key')->toArray();
        }

        // 3. Generate SEO Schema Server-Side to avoid Blade Parse Errors
        $schemaElements = [];
        $position = 1;
        foreach ($packages as $pkg) {
            $schemaElements[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'item' => [
                    '@type' => 'Product',
                    'name' => $pkg->title,
                    'image' => asset($pkg->image),
                    'description' => Str::limit(strip_tags($pkg->description), 160),
                    'offers' => [
                        '@type' => 'Offer',
                        'priceCurrency' => 'IDR',
                        'price' => preg_replace('/[^0-9]/', '', $pkg->price_value),
                        'availability' => 'https://schema.org/InStock',
                        'url' => url('/').'#paket',
                    ],
                ],
            ];
        }

        $packageSchema = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'itemListElement' => $schemaElements,
        ]);

        // Render view directly instead of caching HTML so dynamic forms (CSRF, sessions) work properly
        return view('landing.index', compact(
            'hero', 'features', 'packages', 'schedules',
            'testimonials', 'articles', 'settings', 'packageSchema',
            'registrationPackages', 'registrationSchedules', 'faqs'
        ));
    }
}
