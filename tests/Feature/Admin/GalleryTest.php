<?php

namespace Tests\Feature\Admin;

use App\Models\GalleryFolder;
use App\Models\GalleryItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = Permission::firstOrCreate(['name' => 'manage_gallery']);
        $role = Role::create(['name' => 'marketing', 'guard_name' => 'web']);
        $role->givePermissionTo($permission);

        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    private function actingAsAdmin(): static
    {
        return $this->actingAs($this->admin);
    }

    private function makeFolder(string $name = 'Manasik'): GalleryFolder
    {
        return GalleryFolder::create(['name' => $name, 'slug' => str($name)->slug()]);
    }

    public function test_index_page_loads(): void
    {
        $folder = $this->makeFolder();

        GalleryItem::create([
            'gallery_folder_id' => $folder->id,
            'title' => 'Foto Manasik 1',
            'image' => 'assets/img/gallery/manasik_1.webp',
        ]);

        $response = $this->actingAsAdmin()->get(route('admin.gallery.index'));

        $response->assertOk();
        $response->assertSee('Manasik');
        $response->assertSee('Foto Manasik 1');
    }

    public function test_index_page_filters_by_folder(): void
    {
        $manasik = $this->makeFolder();
        $ziarah = $this->makeFolder('Ziarah');

        GalleryItem::create([
            'gallery_folder_id' => $manasik->id,
            'title' => 'Foto Manasik 1',
            'image' => 'assets/img/gallery/manasik_1.webp',
        ]);

        GalleryItem::create([
            'gallery_folder_id' => $ziarah->id,
            'title' => 'Foto Ziarah 1',
            'image' => 'assets/img/gallery/ziarah_1.webp',
        ]);

        $response = $this->actingAsAdmin()
            ->get(route('admin.gallery.index', ['folder_id' => $manasik->id]));

        $response->assertOk();
        $response->assertSee('Foto Manasik 1');
        $response->assertDontSee('Foto Ziarah 1');
    }

    public function test_create_page_loads_with_folders(): void
    {
        $this->makeFolder();

        $response = $this->actingAsAdmin()->get(route('admin.gallery.create'));

        $response->assertOk();
        $response->assertSee('Manasik');
    }

    public function test_admin_can_create_gallery_item_in_existing_folder(): void
    {
        Storage::fake('public_root');

        $folder = $this->makeFolder();

        $response = $this->actingAsAdmin()
            ->post(route('admin.gallery.store'), [
                'title' => 'Manasik Akbar 2026',
                'folder_id' => $folder->id,
                'image' => UploadedFile::fake()->image('manasik.jpg'),
            ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('gallery_items', [
            'gallery_folder_id' => $folder->id,
            'title' => 'Manasik Akbar 2026',
        ]);
    }

    public function test_admin_can_create_gallery_item_with_new_folder(): void
    {
        Storage::fake('public_root');

        $response = $this->actingAsAdmin()
            ->post(route('admin.gallery.store'), [
                'title' => 'Hotel Makkah View',
                'new_folder_name' => 'Makkah Luxury',
                'image' => UploadedFile::fake()->image('hotel.jpg'),
            ]);

        $response->assertRedirect(route('admin.gallery.index'));

        $folder = GalleryFolder::where('slug', 'makkah-luxury')->first();
        $this->assertNotNull($folder);
        $this->assertDatabaseHas('gallery_items', [
            'gallery_folder_id' => $folder->id,
            'title' => 'Hotel Makkah View',
        ]);
    }

    public function test_creating_gallery_item_validation_fails_without_required_fields(): void
    {
        $response = $this->actingAsAdmin()
            ->post(route('admin.gallery.store'), [
                'title' => '',
                'folder_id' => $this->makeFolder()->id,
            ]);

        $response->assertSessionHasErrors(['title', 'image']);
    }

    public function test_edit_page_loads_with_gallery_data(): void
    {
        $gallery = GalleryItem::create([
            'gallery_folder_id' => $this->makeFolder()->id,
            'title' => 'Foto Manasik 1',
            'image' => 'assets/img/gallery/manasik_1.webp',
        ]);

        $response = $this->actingAsAdmin()
            ->get(route('admin.gallery.edit', $gallery->id));

        $response->assertOk();
        $response->assertSee('Foto Manasik 1');
        $response->assertSee('Manasik');
    }

    public function test_admin_can_update_gallery_item(): void
    {
        Storage::fake('public_root');

        $gallery = GalleryItem::create([
            'gallery_folder_id' => $this->makeFolder()->id,
            'title' => 'Foto Lama',
            'image' => 'assets/img/gallery/lama.webp',
        ]);

        $response = $this->actingAsAdmin()
            ->put(route('admin.gallery.update', $gallery->id), [
                'title' => 'Foto Baru Terupdate',
                'image' => UploadedFile::fake()->image('baru.jpg'),
            ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('gallery_items', [
            'id' => $gallery->id,
            'title' => 'Foto Baru Terupdate',
        ]);
    }

    public function test_admin_can_delete_gallery_item(): void
    {
        $gallery = GalleryItem::create([
            'gallery_folder_id' => $this->makeFolder()->id,
            'title' => 'Hapus Foto Ini',
            'image' => 'assets/img/gallery/hapus.webp',
        ]);

        $response = $this->actingAsAdmin()
            ->delete(route('admin.gallery.destroy', $gallery->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('gallery_items', ['id' => $gallery->id]);
    }

    public function test_user_without_permission_is_forbidden(): void
    {
        $sales = User::factory()->create();
        $sales->assignRole(Role::create(['name' => 'sales', 'guard_name' => 'web']));

        $this->actingAs($sales)
            ->get(route('admin.gallery.index'))
            ->assertForbidden();
    }
}
