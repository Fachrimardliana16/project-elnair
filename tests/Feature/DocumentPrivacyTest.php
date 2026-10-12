<?php

namespace Tests\Feature;

use App\Models\Jamaah;
use App\Models\User;
use App\Support\JamaahFileStorage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class DocumentPrivacyTest extends TestCase
{
    use RefreshDatabase;

    public function test_jemaah_document_page_uses_private_document_route_not_public_storage_url(): void
    {
        Storage::fake(JamaahFileStorage::DISK);
        Storage::disk(JamaahFileStorage::DISK)->put('documents/ktp.pdf', 'private-document');

        $jemaah = Jamaah::create([
            'name' => 'Jemaah Test',
            'nik' => '3171010101010001',
            'whatsapp' => '081234567890',
            'ktp_file' => 'documents/ktp.pdf',
            'status' => 'Approved',
        ]);

        $this->withSession(['jemaah_id' => $jemaah->id])
            ->get(route('jemaah.documents'))
            ->assertOk()
            ->assertSee(route('jemaah.documents.show', 'ktp_file'), false)
            ->assertDontSee('/storage/documents/ktp.pdf', false);
    }

    public function test_admin_with_document_permission_can_view_private_document(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::firstOrCreate(['name' => 'manage_documents']);
        $role = Role::firstOrCreate(['name' => 'operasional']);
        $role->syncPermissions(['manage_documents']);

        Storage::fake(JamaahFileStorage::DISK);
        Storage::disk(JamaahFileStorage::DISK)->put('documents/ktp.pdf', 'private-document');

        $admin = User::factory()->create();
        $admin->assignRole($role);

        $jemaah = Jamaah::create([
            'name' => 'Jemaah Test',
            'nik' => '3171010101010001',
            'whatsapp' => '081234567890',
            'ktp_file' => 'documents/ktp.pdf',
            'status' => 'Approved',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.jamaah-documents.show', [$jemaah, 'ktp_file']))
            ->assertOk();
    }
}
