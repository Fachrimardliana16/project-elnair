<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private User $superadmin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role              = \Spatie\Permission\Models\Role::create(['name' => 'superadmin', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->superadmin  = User::factory()->create();
        $this->superadmin->assignRole($role);
    }

    /** @test */
    public function index_page_loads(): void
    {
        $this->actingAs($this->superadmin)
             ->get(route('admin.users.index'))
             ->assertOk();
    }

    /** @test */
    public function create_page_loads(): void
    {
        $this->actingAs($this->superadmin)
             ->get(route('admin.users.create'))
             ->assertOk();
    }

    /** @test */
    public function superadmin_can_create_user(): void
    {
        $this->actingAs($this->superadmin)
             ->post(route('admin.users.store'), [
                 'name'                  => 'New Admin',
                 'email'                 => 'newadmin@test.com',
                 'password'              => 'password123',
                 'password_confirmation' => 'password123',
                 'roles'                 => ['admin'],
             ])
             ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['email' => 'newadmin@test.com']);
    }

    /** @test */
    public function creating_user_without_name_fails(): void
    {
        $response = $this->actingAs($this->superadmin)
                         ->post(route('admin.users.store'), [
                             'email'                 => 'user@test.com',
                             'password'              => 'password123',
                             'password_confirmation' => 'password123',
                             'roles'                 => ['admin'],
                         ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function creating_user_with_mismatched_password_fails(): void
    {
        $response = $this->actingAs($this->superadmin)
                         ->post(route('admin.users.store'), [
                             'name'                  => 'Test User',
                             'email'                 => 'test@test.com',
                             'password'              => 'password123',
                             'password_confirmation' => 'different',
                             'roles'                 => ['admin'],
                         ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function creating_user_with_duplicate_email_fails(): void
    {
        User::factory()->create(['email' => 'dup@test.com']);

        $response = $this->actingAs($this->superadmin)
                         ->post(route('admin.users.store'), [
                             'name'                  => 'Dup User',
                             'email'                 => 'dup@test.com',
                             'password'              => 'password123',
                             'password_confirmation' => 'password123',
                             'roles'                 => ['admin'],
                         ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function superadmin_can_update_user(): void
    {
        $user = User::factory()->create(['name' => 'Old Name']);

        $this->actingAs($this->superadmin)
             ->put(route('admin.users.update', $user->id), [
                 'name'   => 'New Name',
                 'email'  => $user->email,
                 'roles'  => ['admin'],
             ])
             ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['name' => 'New Name']);
    }

    /** @test */
    public function superadmin_can_delete_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->superadmin)
             ->delete(route('admin.users.destroy', $user->id))
             ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function password_is_required_when_short(): void
    {
        $response = $this->actingAs($this->superadmin)
                         ->post(route('admin.users.store'), [
                             'name'                  => 'Test',
                             'email'                 => 'test@test.com',
                             'password'              => 'short',
                             'password_confirmation' => 'short',
                             'roles'                 => ['admin'],
                         ]);

        $response->assertSessionHasErrors('password');
    }
}
