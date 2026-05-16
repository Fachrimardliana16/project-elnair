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
            $view->with('settings', \App\Models\SiteSetting::pluck('value', 'key')->toArray());
        });
    }
}
