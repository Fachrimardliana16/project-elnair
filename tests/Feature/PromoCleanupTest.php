<?php

namespace Tests\Feature;

use App\Models\Promo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class PromoCleanupTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::firstOrCreate(['name' => 'manage_promos']);
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->syncPermissions(['manage_promos']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    public function test_old_promo_files_are_deleted_when_replaced(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('promos/old.jpg', 'old-image');
        Storage::disk('public')->put('promos/pdf/old.pdf', 'old-pdf');

        $promo = Promo::create([
            'title' => 'Promo Lama',
            'slug' => 'promo-lama',
            'image' => 'promos/old.jpg',
            'pdf_file' => 'promos/pdf/old.pdf',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->actingAs($this->admin)->put(route('admin.promos.update', $promo), [
            'title' => 'Promo Baru',
            'image' => UploadedFile::fake()->image('new.jpg'),
            'pdf_file' => UploadedFile::fake()->create('new.pdf', 128, 'application/pdf'),
            'is_active' => '1',
            'sort_order' => 1,
        ])->assertRedirect(route('admin.promos.index'));

        Storage::disk('public')->assertMissing('promos/old.jpg');
        Storage::disk('public')->assertMissing('promos/pdf/old.pdf');
        $this->assertNotSame('promos/old.jpg', $promo->fresh()->image);
        $this->assertNotSame('promos/pdf/old.pdf', $promo->fresh()->pdf_file);
    }

    public function test_promo_files_are_deleted_when_promo_is_deleted(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('promos/delete.jpg', 'image');
        Storage::disk('public')->put('promos/pdf/delete.pdf', 'pdf');

        $promo = Promo::create([
            'title' => 'Promo Hapus',
            'slug' => 'promo-hapus',
            'image' => 'promos/delete.jpg',
            'pdf_file' => 'promos/pdf/delete.pdf',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.promos.destroy', $promo))
            ->assertRedirect(route('admin.promos.index'));

        Storage::disk('public')->assertMissing('promos/delete.jpg');
        Storage::disk('public')->assertMissing('promos/pdf/delete.pdf');
    }
}
