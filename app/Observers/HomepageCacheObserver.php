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
    /**
     * Clears the full HTML page cache in addition to the specific data cache.
     * Called by every saved() method so any content change invalidates the cached page.
     */
    private function clearHtmlCache(): void
    {
        Cache::forget('homepage_html');
    }

    // -----------------------------------------------------------------
    // HeroSetting
    // -----------------------------------------------------------------

    public function heroSaved(): void
    {
        Cache::forget('homepage_hero');
        $this->clearHtmlCache();
        Log::channel('activity')->info('Cache busted: homepage_hero + homepage_html');
    }

    // -----------------------------------------------------------------
    // Feature
    // -----------------------------------------------------------------

    public function featureSaved(): void
    {
        Cache::forget('homepage_features');
        $this->clearHtmlCache();
        Log::channel('activity')->info('Cache busted: homepage_features + homepage_html');
    }

    // -----------------------------------------------------------------
    // Package
    // -----------------------------------------------------------------

    public function packageSaved(): void
    {
        Cache::forget('homepage_packages');
        $this->clearHtmlCache();
        Log::channel('activity')->info('Cache busted: homepage_packages + homepage_html');
    }

    // -----------------------------------------------------------------
    // DepartureSchedule
    // -----------------------------------------------------------------

    public function scheduleSaved(): void
    {
        Cache::forget('homepage_schedules');
        $this->clearHtmlCache();
        Log::channel('activity')->info('Cache busted: homepage_schedules + homepage_html');
    }

    // -----------------------------------------------------------------
    // Testimonial
    // -----------------------------------------------------------------

    public function testimonialSaved(): void
    {
        Cache::forget('homepage_testimonials');
        $this->clearHtmlCache();
        Log::channel('activity')->info('Cache busted: homepage_testimonials + homepage_html');
    }

    // -----------------------------------------------------------------
    // Article
    // -----------------------------------------------------------------

    public function articleSaved(): void
    {
        Cache::forget('homepage_articles');
        $this->clearHtmlCache();
        Log::channel('activity')->info('Cache busted: homepage_articles + homepage_html');
    }

    // -----------------------------------------------------------------
    // SiteSetting
    // -----------------------------------------------------------------

    public function settingSaved(): void
    {
        Cache::forget('homepage_settings');
        Cache::forget('site_settings_global');
        $this->clearHtmlCache();
        Log::channel('activity')->info('Cache busted: homepage_settings + site_settings_global + homepage_html');
    }
}
