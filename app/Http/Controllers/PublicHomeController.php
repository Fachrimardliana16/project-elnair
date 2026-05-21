<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\HeroSetting;
use App\Models\Feature;
use App\Models\Package;
use App\Models\DepartureSchedule;
use App\Models\Testimonial;
use App\Models\Article;
use App\Models\SiteSetting;
use App\Models\LandingPage;
use Illuminate\Support\Str;

class PublicHomeController extends Controller
{
    /**
     * Display the public homepage with full caching, custom-domain detection,
     * and server-side SEO schema generation.
     */
    public function index(Request $request): \Illuminate\Http\Response|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        // 1. Dynamic Domain Masking — guard against empty host matching empty custom_domain
        $host = $request->getHost();
        if (!empty($host)) {
            $customPage = LandingPage::where('custom_domain', $host)
                ->where('is_active', true)
                ->first();
            if ($customPage) {
                try {
                    return app(PublicLandingPageController::class)->show($customPage->slug);
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    // Fallback to normal homepage if the page is no longer accessible
                }
            }
        }

        // 2. Cache all homepage queries for 5 minutes (TTL = 300 seconds)
        $hero         = Cache::remember('homepage_hero', 300, fn () => HeroSetting::first());
        $features     = Cache::remember('homepage_features', 300, fn () => Feature::orderBy('order')->get());
        $packages     = Cache::remember('homepage_packages', 300, fn () => Package::where('is_active', true)->take(3)->get());
        $schedules    = Cache::remember('homepage_schedules', 300, fn () => DepartureSchedule::with('package')
                            ->where('is_active', true)
                            ->where('departure_date', '>=', now())
                            ->orderBy('departure_date', 'asc')
                            ->take(5)
                            ->get());
        $testimonials = Cache::remember('homepage_testimonials', 300, fn () => Testimonial::all());
        $articles     = Cache::remember('homepage_articles', 300, fn () => Article::where('status', 'published')->orderBy('created_at', 'desc')->take(3)->get());
        $settings     = Cache::remember('homepage_settings', 300, fn () => SiteSetting::pluck('value', 'key')->toArray());

        // Guard: if cache returned stale/corrupt data (non-objects), bust and re-query fresh
        if (!($packages instanceof \Illuminate\Support\Collection) || ($packages->isNotEmpty() && !($packages->first() instanceof Package))) {
            Cache::forget('homepage_packages');
            $packages = Package::where('is_active', true)->take(3)->get();
        }
        if (!($features instanceof \Illuminate\Support\Collection) || ($features->isNotEmpty() && !($features->first() instanceof Feature))) {
            Cache::forget('homepage_features');
            $features = Feature::orderBy('order')->get();
        }
        if (!($testimonials instanceof \Illuminate\Support\Collection) || ($testimonials->isNotEmpty() && !($testimonials->first() instanceof Testimonial))) {
            Cache::forget('homepage_testimonials');
            $testimonials = Testimonial::all();
        }
        if (!($articles instanceof \Illuminate\Support\Collection) || ($articles->isNotEmpty() && !($articles->first() instanceof Article))) {
            Cache::forget('homepage_articles');
            $articles = Article::where('status', 'published')->orderBy('created_at', 'desc')->take(3)->get();
        }
        if (!is_array($settings)) {
            Cache::forget('homepage_settings');
            $settings = SiteSetting::pluck('value', 'key')->toArray();
        }

        // 3. Generate SEO Schema Server-Side to avoid Blade Parse Errors
        $schemaElements = [];
        $position = 1;
        foreach ($packages as $pkg) {
            $schemaElements[] = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'item'     => [
                    '@type'       => 'Product',
                    'name'        => $pkg->title,
                    'image'       => asset($pkg->image),
                    'description' => Str::limit(strip_tags($pkg->description), 160),
                    'offers'      => [
                        '@type'          => 'Offer',
                        'priceCurrency'  => 'IDR',
                        'price'          => preg_replace('/[^0-9]/', '', $pkg->price_value),
                        'availability'   => 'https://schema.org/InStock',
                        'url'            => url('/') . '#paket',
                    ],
                ],
            ];
        }

        $packageSchema = json_encode([
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            'itemListElement' => $schemaElements,
        ]);

        return view('landing.index', compact(
            'hero', 'features', 'packages', 'schedules',
            'testimonials', 'articles', 'settings', 'packageSchema'
        ));
    }
}
