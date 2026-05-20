<?php

namespace Tests\Feature\Admin;

use App\Models\LandingPage;
use App\Models\LandingPageLead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for Lead status mutations.
 * Verifies: status transitions, activity log creation, and access control.
 */
class LeadStatusTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private LandingPage $page;
    private LandingPageLead $lead;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role        = \Spatie\Permission\Models\Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);

        $this->page = LandingPage::create([
            'title'     => 'Test Page',
            'slug'      => 'test-page',
            'is_active' => true,
        ]);

        $this->lead = LandingPageLead::create([
            'landing_page_id' => $this->page->id,
            'name'            => 'Ahmad Fauzi',
            'phone'           => '081234567890',
            'status'          => 'new',
        ]);
    }

    /** @test */
    public function admin_can_update_lead_status_to_contacted(): void
    {
        $this->actingAs($this->admin)
             ->patch(route('admin.landing-pages.leads.update-status', $this->lead->id), [
                 'status' => 'contacted',
             ])
             ->assertRedirect();

        $this->assertDatabaseHas('landing_page_leads', [
            'id'     => $this->lead->id,
            'status' => 'contacted',
        ]);
    }

    /** @test */
    public function admin_can_update_lead_status_to_converted(): void
    {
        $this->actingAs($this->admin)
             ->patch(route('admin.landing-pages.leads.update-status', $this->lead->id), [
                 'status' => 'converted',
             ])
             ->assertRedirect();

        $this->assertDatabaseHas('landing_page_leads', [
            'id'     => $this->lead->id,
            'status' => 'converted',
        ]);
    }

    /** @test */
    public function invalid_status_value_is_rejected(): void
    {
        $this->actingAs($this->admin)
             ->patch(route('admin.landing-pages.leads.update-status', $this->lead->id), [
                 'status' => 'invalid_status_xyz',
             ])
             ->assertSessionHasErrors('status');

        // Original status must remain untouched
        $this->assertDatabaseHas('landing_page_leads', [
            'id'     => $this->lead->id,
            'status' => 'new',
        ]);
    }

    /** @test */
    public function guest_cannot_update_lead_status(): void
    {
        $this->patch(route('admin.landing-pages.leads.update-status', $this->lead->id), [
            'status' => 'contacted',
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function activity_log_is_created_on_status_update(): void
    {
        $this->actingAs($this->admin)
             ->patch(route('admin.landing-pages.leads.update-status', $this->lead->id), [
                 'status' => 'converted',
             ]);

        $this->assertDatabaseHas('activity_logs', [
            'subject_type' => LandingPageLead::class,
            'subject_id'   => $this->lead->id,
            'action'       => 'status_update',
        ]);
    }
}
