<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role        = \Spatie\Permission\Models\Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    private function actingAsAdmin(): static
    {
        return $this->actingAs($this->admin);
    }

    /** @test */
    public function index_page_loads_for_admin(): void
    {
        $this->actingAsAdmin()
             ->get(route('admin.packages.index'))
             ->assertOk();
    }

    /** @test */
    public function create_page_loads(): void
    {
        $this->actingAsAdmin()
             ->get(route('admin.packages.create'))
             ->assertOk();
    }

    /** @test */
    public function admin_can_create_package_with_valid_data(): void
    {
        Storage::fake('public_root');

        $this->actingAsAdmin()
             ->post(route('admin.packages.store'), [
                 'title'       => 'Umrah Reguler',
                 'price_label' => 'IDR',
                 'price_value' => '25jt',
                 'description' => 'Paket umrah reguler dengan layanan terbaik.',
                 'image'       => UploadedFile::fake()->image('paket.jpg', 800, 600),
                 'is_active'   => '1',
             ])
             ->assertRedirect(route('admin.packages.index'));

        $this->assertDatabaseHas('packages', ['title' => 'Umrah Reguler']);
    }

    /** @test */
    public function creating_package_without_title_fails(): void
    {
        Storage::fake('public_root');

        $response = $this->actingAsAdmin()
                         ->post(route('admin.packages.store'), [
                             'price_label' => 'IDR',
                             'price_value' => '25jt',
                             'description' => 'Deskripsi.',
                             'image'       => UploadedFile::fake()->image('paket.jpg'),
                         ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseEmpty('packages');
    }

    /** @test */
    public function creating_package_without_image_fails(): void
    {
        $response = $this->actingAsAdmin()
                         ->post(route('admin.packages.store'), [
                             'title'       => 'Paket Test',
                             'price_label' => 'IDR',
                             'price_value' => '25jt',
                             'description' => 'Deskripsi paket.',
                         ]);

        $response->assertSessionHasErrors('image');
    }

    /** @test */
    public function edit_page_loads_with_package_data(): void
    {
        $package = Package::create([
            'title'       => 'Paket Haji',
            'price_label' => 'IDR',
            'price_value' => '100jt',
            'description' => 'Deskripsi haji.',
            'slug'        => 'paket-haji',
            'is_active'   => true,
        ]);

        $this->actingAsAdmin()
             ->get(route('admin.packages.edit', $package->id))
             ->assertOk()
             ->assertSee('Paket Haji');
    }

    /** @test */
    public function admin_can_update_package(): void
    {
        $package = Package::create([
            'title'       => 'Paket Lama',
            'price_label' => 'IDR',
            'price_value' => '25jt',
            'description' => 'Deskripsi lama.',
            'slug'        => 'paket-lama',
            'is_active'   => true,
        ]);

        $this->actingAsAdmin()
             ->put(route('admin.packages.update', $package->id), [
                 'title'       => 'Paket Baru',
                 'price_label' => 'IDR',
                 'price_value' => '30jt',
                 'description' => 'Deskripsi baru.',
                 'is_active'   => '1',
             ])
             ->assertRedirect(route('admin.packages.index'));

        $this->assertDatabaseHas('packages', ['title' => 'Paket Baru']);
    }

    /** @test */
    public function admin_can_delete_package(): void
    {
        $package = Package::create([
            'title'       => 'Paket Hapus',
            'price_label' => 'IDR',
            'price_value' => '25jt',
            'description' => 'Akan dihapus.',
            'slug'        => 'paket-hapus',
            'is_active'   => true,
        ]);

        $this->actingAsAdmin()
             ->delete(route('admin.packages.destroy', $package->id))
             ->assertRedirect();

        $this->assertDatabaseMissing('packages', ['id' => $package->id]);
    }

    /** @test */
    public function guests_cannot_access_packages(): void
    {
        $this->get(route('admin.packages.index'))
             ->assertRedirect(route('admin.login'));
    }

    // ── Cache Busting Tests ───────────────────────────────────────────────

    /** @test */
    public function creating_package_busts_homepage_packages_cache(): void
    {
        Storage::fake('public_root');
        \Illuminate\Support\Facades\Cache::put('homepage_packages', 'stale-data', 300);

        $this->actingAsAdmin()
             ->post(route('admin.packages.store'), [
                 'title'       => 'Umrah Cache Test',
                 'price_label' => 'IDR',
                 'price_value' => '27jt',
                 'description' => 'Test cache busting after create.',
                 'image'       => \Illuminate\Http\UploadedFile::fake()->image('test.jpg', 800, 600),
                 'is_active'   => '1',
             ])
             ->assertRedirect(route('admin.packages.index'));

        // After observer fires, cache key must be gone
        $this->assertNull(\Illuminate\Support\Facades\Cache::get('homepage_packages'));
    }

    /** @test */
    public function updating_package_busts_homepage_packages_cache(): void
    {
        Storage::fake('public_root');
        $package = Package::create([
            'title' => 'Cache Pkg', 'price_label' => 'IDR',
            'price_value' => '20jt', 'description' => 'desc',
            'slug' => 'cache-pkg', 'is_active' => true,
        ]);

        \Illuminate\Support\Facades\Cache::put('homepage_packages', 'stale-data', 300);

        $this->actingAsAdmin()
             ->put(route('admin.packages.update', $package->id), [
                 'title'       => 'Cache Pkg Updated',
                 'price_label' => 'IDR',
                 'price_value' => '22jt',
                 'description' => 'Updated description.',
                 'is_active'   => '1',
             ])
             ->assertRedirect(route('admin.packages.index'));

        $this->assertNull(\Illuminate\Support\Facades\Cache::get('homepage_packages'));
    }

    /** @test */
    public function deleting_package_busts_homepage_packages_cache(): void
    {
        $package = Package::create([
            'title' => 'To Delete', 'price_label' => 'IDR',
            'price_value' => '15jt', 'description' => 'desc',
            'slug' => 'to-delete', 'is_active' => true,
        ]);

        \Illuminate\Support\Facades\Cache::put('homepage_packages', 'stale-data', 300);

        $this->actingAsAdmin()
             ->delete(route('admin.packages.destroy', $package->id))
             ->assertRedirect();

        $this->assertNull(\Illuminate\Support\Facades\Cache::get('homepage_packages'));
    }

    // ── Boundary / Negative Tests ─────────────────────────────────────────

    /** @test */
    public function creating_package_with_title_exceeding_255_chars_fails(): void
    {
        Storage::fake('public_root');

        $this->actingAsAdmin()
             ->post(route('admin.packages.store'), [
                 'title'       => str_repeat('P', 256),
                 'price_label' => 'IDR',
                 'price_value' => '25jt',
                 'description' => 'Deskripsi.',
                 'image'       => \Illuminate\Http\UploadedFile::fake()->image('paket.jpg'),
                 'is_active'   => '1',
             ])
             ->assertSessionHasErrors('title');
    }
}
