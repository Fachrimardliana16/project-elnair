<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = \App\Models\SiteSetting::pluck('value', 'key')->toArray();
            
            // Generate Organization Schema Server-Side for absolute stability
            $orgSchema = json_encode([
                "@context" => "https://schema.org",
                "@type" => "Organization",
                "name" => $settings['site_name'] ?? 'Elnair Travel',
                "url" => url('/'),
                "logo" => asset($settings['logo'] ?? 'assets/img/logo-full.png'),
                "sameAs" => [
                    $settings['facebook_url'] ?? '',
                    $settings['instagram_url'] ?? ''
                ]
            ]);

            $view->with('settings', $settings);
            $view->with('orgSchema', $orgSchema);
        });
    }
}
