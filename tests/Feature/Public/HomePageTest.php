<?php

namespace Tests\Feature\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function homepage_is_accessible(): void
    {
        $this->get('/')
             ->assertOk();
    }

    /** @test */
    public function article_listing_page_is_accessible(): void
    {
        $this->get('/artikel')
             ->assertOk();
    }

    /** @test */
    public function about_page_is_accessible(): void
    {
        $this->get('/tentang-kami')
             ->assertOk();
    }

    /** @test */
    public function nonexistent_route_returns_404(): void
    {
        $this->get('/halaman-tidak-ada')
             ->assertNotFound();
    }

    // ── Cache Tests ───────────────────────────────────────────────────────

    /** @test */
    public function homepage_populates_cache_on_first_load(): void
    {
        Cache::flush();

        $this->get('/')->assertOk();

        // After homepage loads, at least the settings key should be cached
        $this->assertNotNull(Cache::get('homepage_settings'));
    }

    /** @test */
    public function homepage_serves_from_cache_on_second_load(): void
    {
        // Pre-populate cache
        Cache::put('homepage_settings', ['site_name' => 'Elnair Travel'], 300);
        Cache::put('homepage_hero', null, 300);
        Cache::put('homepage_features', collect(), 300);
        Cache::put('homepage_packages', collect(), 300);
        Cache::put('homepage_schedules', collect(), 300);
        Cache::put('homepage_testimonials', collect(), 300);
        Cache::put('homepage_articles', collect(), 300);

        // Second load should not hit DB for settings; no exception expected
        $this->get('/')->assertOk();
    }
}
