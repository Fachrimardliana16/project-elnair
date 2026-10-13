<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permission jika belum ada
        $promoPerm = Permission::firstOrCreate(['name' => 'manage_promos']);
        $workflowPerm = Permission::firstOrCreate(['name' => 'manage_workflows']);

        // Pastikan superadmin & owner mendapatkan semua permission
        foreach (['superadmin', 'owner'] as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo([$promoPerm, $workflowPerm]);
            }
        }

        // Role Admin mengelola Promo & Alur Kerja
        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $admin->givePermissionTo([$promoPerm, $workflowPerm]);
        }

        // Role Marketing mengelola Promo
        $marketing = Role::where('name', 'marketing')->first();
        if ($marketing) {
            $marketing->givePermissionTo($promoPerm);
        }

        // Role Operasional mengelola Alur Kerja (Workflow)
        $operasional = Role::where('name', 'operasional')->first();
        if ($operasional) {
            $operasional->givePermissionTo($workflowPerm);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Optional rollback: tidak menghapus izin agar data role yang sudah disesuaikan tidak rusak
    }
};
