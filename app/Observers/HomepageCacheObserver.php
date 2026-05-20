<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * HomepageCacheObserver
 *
 * Automatically invalidates the relevant homepage cache keys whenever
 * a model that feeds homepage data is saved, updated, or deleted.
 * This implements the Cache-Busting / Invalidation strategy so marketers
 * and admins see their changes reflected immediately without manual
 * cache-clearing intervention.
 */
class HomepageCacheObserver
{
    // -----------------------------------------------------------------
    // HeroSetting
    // -----------------------------------------------------------------

    public function heroSaved(): void
    {
        Cache::forget('homepage_hero');
        Log::channel('activity')->info('Cache busted: homepage_hero');
    }

    // -----------------------------------------------------------------
    // Feature
    // -----------------------------------------------------------------

    public function featureSaved(): void
    {
        Cache::forget('homepage_features');
        Log::channel('activity')->info('Cache busted: homepage_features');
    }

    // -----------------------------------------------------------------
    // Package
    // -----------------------------------------------------------------

    public function packageSaved(): void
    {
        Cache::forget('homepage_packages');
        Log::channel('activity')->info('Cache busted: homepage_packages');
    }

    // -----------------------------------------------------------------
    // DepartureSchedule
    // -----------------------------------------------------------------

    public function scheduleSaved(): void
    {
        Cache::forget('homepage_schedules');
        Log::channel('activity')->info('Cache busted: homepage_schedules');
    }

    // -----------------------------------------------------------------
    // Testimonial
    // -----------------------------------------------------------------

    public function testimonialSaved(): void
    {
        Cache::forget('homepage_testimonials');
        Log::channel('activity')->info('Cache busted: homepage_testimonials');
    }

    // -----------------------------------------------------------------
    // Article
    // -----------------------------------------------------------------

    public function articleSaved(): void
    {
        Cache::forget('homepage_articles');
        Log::channel('activity')->info('Cache busted: homepage_articles');
    }

    // -----------------------------------------------------------------
    // SiteSetting
    // -----------------------------------------------------------------

    public function settingSaved(): void
    {
        Cache::forget('homepage_settings');
        Cache::forget('site_settings_global');
        Log::channel('activity')->info('Cache busted: homepage_settings + site_settings_global');
    }
}
