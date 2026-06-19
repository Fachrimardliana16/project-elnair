<?php

namespace Tests\Feature\Admin;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    private function actingAsAdmin(): static
    {
        return $this->actingAs($this->admin);
    }

    public function test_index_page_loads(): void
    {
        // Seed some gallery items
        Gallery::create([
            'title' => 'Foto Manasik 1',
            'image' => 'assets/img/gallery/manasik_1.webp',
            'category' => 'Manasik',
        ]);

        Gallery::create([
            'title' => 'Foto Keberangkatan 1',
            'image' => 'assets/img/gallery/keberangkatan_1.webp',
            'category' => 'Keberangkatan',
        ]);

        // Get index page
        $response = $this->actingAsAdmin()
            ->get(route('admin.gallery.index'));

        $response->assertOk();
        $response->assertSee('Manasik');
        $response->assertSee('Keberangkatan');
        $response->assertSee('Foto Manasik 1');
        $response->assertSee('Foto Keberangkatan 1');
    }

    public function test_index_page_filters_by_category(): void
    {
        Gallery::create([
            'title' => 'Foto Manasik 1',
            'image' => 'assets/img/gallery/manasik_1.webp',
            'category' => 'Manasik',
        ]);

        Gallery::create([
            'title' => 'Foto Keberangkatan 1',
            'image' => 'assets/img/gallery/keberangkatan_1.webp',
            'category' => 'Keberangkatan',
        ]);

        // Filter by Manasik
        $response = $this->actingAsAdmin()
            ->get(route('admin.gallery.index', ['category' => 'Manasik']));

        $response->assertOk();
        $response->assertSee('Foto Manasik 1');
        $response->assertDontSee('Foto Keberangkatan 1');
    }

    public function test_create_page_loads_with_categories(): void
    {
        Gallery::create([
            'title' => 'Foto Manasik 1',
            'image' => 'assets/img/gallery/manasik_1.webp',
            'category' => 'Manasik',
        ]);

        $response = $this->actingAsAdmin()
            ->get(route('admin.gallery.create'));

        $response->assertOk();
        $response->assertSee('Manasik'); // Predefined and loaded category
    }

    public function test_admin_can_create_gallery_item_with_predefined_category(): void
    {
        Storage::fake('public_root');

        $response = $this->actingAsAdmin()
            ->post(route('admin.gallery.store'), [
                'title' => 'Manasik Akbar 2026',
                'category' => 'Manasik',
                'image' => UploadedFile::fake()->image('manasik.jpg'),
            ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('galleries', [
            'title' => 'Manasik Akbar 2026',
            'category' => 'Manasik',
        ]);
    }

    public function test_admin_can_create_gallery_item_with_custom_category(): void
    {
        Storage::fake('public_root');

        $response = $this->actingAsAdmin()
            ->post(route('admin.gallery.store'), [
                'title' => 'Hotel Makkah View',
                'category' => 'Makkah Luxury',
                'image' => UploadedFile::fake()->image('hotel.jpg'),
            ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('galleries', [
            'title' => 'Hotel Makkah View',
            'category' => 'Makkah Luxury',
        ]);
    }

    public function test_creating_gallery_item_validation_fails_without_required_fields(): void
    {
        $response = $this->actingAsAdmin()
            ->post(route('admin.gallery.store'), [
                'title' => '',
                'category' => 'Manasik',
            ]);

        $response->assertSessionHasErrors(['title', 'image']);
    }

    public function test_edit_page_loads_with_gallery_data(): void
    {
        $gallery = Gallery::create([
            'title' => 'Foto Manasik 1',
            'image' => 'assets/img/gallery/manasik_1.webp',
            'category' => 'Manasik',
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

        $gallery = Gallery::create([
            'title' => 'Foto Lama',
            'image' => 'assets/img/gallery/lama.webp',
            'category' => 'Manasik',
        ]);

        $response = $this->actingAsAdmin()
            ->put(route('admin.gallery.update', $gallery->id), [
                'title' => 'Foto Baru Terupdate',
                'category' => 'Keberangkatan',
                'image' => UploadedFile::fake()->image('baru.jpg'),
            ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'title' => 'Foto Baru Terupdate',
            'category' => 'Keberangkatan',
        ]);
    }

    public function test_admin_can_delete_gallery_item(): void
    {
        $gallery = Gallery::create([
            'title' => 'Hapus Foto Ini',
            'image' => 'assets/img/gallery/hapus.webp',
            'category' => 'Ziarah',
        ]);

        $response = $this->actingAsAdmin()
            ->delete(route('admin.gallery.destroy', $gallery->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('galleries', [
            'id' => $gallery->id,
        ]);
    }
}
