<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\HeroSetting;
use App\Models\Feature;
use App\Models\Package;
use App\Models\DepartureSchedule;
use App\Models\Testimonial;
use App\Models\Article;
use App\Models\SiteSetting;
use App\Observers\HeroSettingObserver;
use App\Observers\FeatureObserver;
use App\Observers\PackageObserver;
use App\Observers\DepartureScheduleObserver;
use App\Observers\TestimonialObserver;
use App\Observers\ArticleObserver;
use App\Observers\SiteSettingObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ----------------------------------------------------------------
        // 1. Global gate: superadmin bypasses all permission checks
        // ----------------------------------------------------------------
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });

        // ----------------------------------------------------------------
        // 2. Register Eloquent Observers for automatic cache busting
        //    Every saved/deleted event invalidates the relevant cache key
        //    so the homepage always shows fresh data without manual intervention.
        // ----------------------------------------------------------------
        HeroSetting::observe(HeroSettingObserver::class);
        Feature::observe(FeatureObserver::class);
        Package::observe(PackageObserver::class);
        DepartureSchedule::observe(DepartureScheduleObserver::class);
        Testimonial::observe(TestimonialObserver::class);
        Article::observe(ArticleObserver::class);
        SiteSetting::observe(SiteSettingObserver::class);

        // ----------------------------------------------------------------
        // 3. Global view composer — inject $settings and $orgSchema into
        //    every view using a short-lived cache (TTL 300s) so every
        //    server node in a load-balanced cluster reads from shared
        //    Redis/database cache instead of hitting the DB per request.
        // ----------------------------------------------------------------
        View::composer('*', function ($view) {
            $settings = Cache::remember('site_settings_global', 300, fn () =>
                SiteSetting::pluck('value', 'key')->toArray()
            );

            $orgSchema = json_encode([
                '@context' => 'https://schema.org',
                '@type'    => 'Organization',
                'name'     => $settings['site_name'] ?? 'Elnair Travel',
                'url'      => url('/'),
                'logo'     => asset($settings['logo'] ?? 'assets/img/logo-full.png'),
                'sameAs'   => array_filter([
                    $settings['facebook_url'] ?? '',
                    $settings['instagram_url'] ?? '',
                ]),
            ]);

            $view->with('settings', $settings);
            $view->with('orgSchema', $orgSchema);
        });

        // ----------------------------------------------------------------
        // 4. Footer-specific view composer: provide $packages to the footer
        //    without repeating the query on every page load.
        // ----------------------------------------------------------------
        View::composer('landing.sections.footer.index', function ($view) {
            $view->with('packages', Cache::remember(
                'footer_packages', 300,
                fn () => Package::where('is_active', true)->take(3)->get()
            ));
        });
    }
}

