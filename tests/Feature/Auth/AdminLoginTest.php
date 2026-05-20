<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Spatie permission requires this for in-memory SQLite
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /** @test */
    public function login_page_is_accessible(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    /** @test */
    public function admin_can_login_with_valid_credentials(): void
    {
        $role = \Spatie\Permission\Models\Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $user = User::factory()->create([
            'email'    => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($role);

        $response = $this->post(route('admin.login'), [
            'email'    => 'admin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('admin.login'), [
            'email'    => 'admin@test.com',
            'password' => 'wrong_password',
        ]);

        $response->assertRedirect();
        $this->assertGuest();
    }

    /** @test */
    public function login_fails_with_unknown_email(): void
    {
        $response = $this->post(route('admin.login'), [
            'email'    => 'nobody@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $this->assertGuest();
    }

    /** @test */
    public function unauthenticated_user_is_redirected_from_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_logout(): void
    {
        $role = \Spatie\Permission\Models\Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->post(route('admin.logout'));
        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    /** @test */
    public function user_without_admin_role_is_denied(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect('/');
    }
}
