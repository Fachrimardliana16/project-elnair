<?php

namespace Tests\Feature\Public;

use App\Models\LandingPage;
use App\Models\LandingPageLead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    private LandingPage $page;

    protected function setUp(): void
    {
        parent::setUp();

        $this->page = LandingPage::create([
            'title'     => 'Promo Ramadhan',
            'slug'      => 'promo-ramadhan',
            'is_active' => true,
        ]);
    }

    /** @test */
    public function landing_page_is_accessible_by_slug(): void
    {
        $response = $this->get('/p/promo-ramadhan');
        $response->assertOk();
    }

    /** @test */
    public function inactive_landing_page_returns_404(): void
    {
        LandingPage::create([
            'title'     => 'Halaman Nonaktif',
            'slug'      => 'halaman-nonaktif',
            'is_active' => false,
        ]);

        $this->get('/p/halaman-nonaktif')
             ->assertNotFound();
    }

    /** @test */
    public function visitor_can_submit_a_lead(): void
    {
        $response = $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => 'Budi Santoso',
            'phone' => '08123456789',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('landing_page_leads', [
            'landing_page_id' => $this->page->id,
            'name'            => 'Budi Santoso',
        ]);
    }

    /** @test */
    public function lead_submission_fails_without_name(): void
    {
        $response = $this->post(route('landing.lead.store', $this->page->slug), [
            'phone' => '08123456789',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseEmpty('landing_page_leads');
    }

    /** @test */
    public function lead_submission_fails_without_phone(): void
    {
        $response = $this->post(route('landing.lead.store', $this->page->slug), [
            'name' => 'Budi',
        ]);

        $response->assertSessionHasErrors('phone');
        $this->assertDatabaseEmpty('landing_page_leads');
    }

    /** @test */
    public function lead_submission_fails_with_invalid_phone(): void
    {
        $response = $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => 'Budi',
            'phone' => 'bukan-nomor-telepon',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    // ── Boundary Value Tests ───────────────────────────────────────────────

    /** @test */
    public function lead_submission_succeeds_with_name_at_max_255_chars(): void
    {
        $name = str_repeat('A', 255);

        $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => $name,
            'phone' => '08123456789',
        ])->assertRedirect();

        $this->assertDatabaseHas('landing_page_leads', ['name' => $name]);
    }

    /** @test */
    public function lead_submission_fails_with_name_exceeding_255_chars(): void
    {
        $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => str_repeat('A', 256),
            'phone' => '08123456789',
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function lead_submission_succeeds_with_phone_at_minimum_7_digits(): void
    {
        $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => 'Test User',
            'phone' => '0812345',   // 7 digits — lower boundary
        ])->assertRedirect();
    }

    /** @test */
    public function lead_submission_fails_with_phone_shorter_than_7_digits(): void
    {
        $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => 'Test User',
            'phone' => '081234',    // 6 digits — below boundary
        ])->assertSessionHasErrors('phone');
    }

    /** @test */
    public function lead_submission_succeeds_with_phone_at_maximum_20_digits(): void
    {
        $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => 'Test User',
            'phone' => '08123456789012345678', // 20 digits — upper boundary
        ])->assertRedirect();
    }

    /** @test */
    public function lead_submission_fails_with_phone_exceeding_20_digits(): void
    {
        $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => 'Test User',
            'phone' => '081234567890123456789', // 21 digits — above boundary
        ])->assertSessionHasErrors('phone');
    }

    // ── XSS / Security Tests ───────────────────────────────────────────────

    /** @test */
    public function lead_name_strips_html_tags_before_storage(): void
    {
        $this->post(route('landing.lead.store', $this->page->slug), [
            'name'  => '<script>alert("xss")</script>Budi',
            'phone' => '08123456789',
        ]);

        // XSS payload must NOT be stored raw; either stripped or rejected
        $this->assertDatabaseMissing('landing_page_leads', [
            'name' => '<script>alert("xss")</script>Budi',
        ]);
    }

    // ── UTM Attribution Tests ──────────────────────────────────────────────

    /** @test */
    public function utm_parameters_are_persisted_with_lead(): void
    {
        // Simulate UTM values being placed in session by CaptureUtmParameters middleware
        $response = $this->withSession([
            'utm_source'   => 'facebook',
            'utm_medium'   => 'cpc',
            'utm_campaign' => 'ramadhan2025',
            'utm_content'  => 'banner_v2',
            'utm_term'     => 'umrah murah',
        ])->post(route('landing.lead.store', $this->page->slug), [
            'name'  => 'Siti Rahmah',
            'phone' => '082233445566',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('landing_page_leads', [
            'name'         => 'Siti Rahmah',
            'utm_source'   => 'facebook',
            'utm_medium'   => 'cpc',
            'utm_campaign' => 'ramadhan2025',
        ]);
    }
}

