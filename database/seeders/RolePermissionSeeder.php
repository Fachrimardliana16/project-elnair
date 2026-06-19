<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage_users',
            'manage_roles',
            'manage_hero',
            'manage_features',
            'manage_packages',
            'manage_testimonials',
            'manage_settings',
            'manage_gallery',
            'manage_articles',
            'manage_ads',
            'manage_landing_pages',
            'manage_jamaahs',
            'manage_groups',
            'manage_payments',
            'manage_documents',
            'view_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $superAdmin = Role::create(['name' => 'superadmin']);
        $superAdmin->givePermissionTo(Permission::all());

        $owner = Role::create(['name' => 'owner']);
        $owner->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'manage_hero',
            'manage_features',
            'manage_packages',
            'manage_testimonials',
            'manage_settings',
            'manage_gallery',
            'manage_articles',
            'manage_jamaahs',
            'manage_groups',
            'manage_documents',
            'manage_payments',
        ]);

        $marketing = Role::create(['name' => 'marketing']);
        $marketing->givePermissionTo([
            'manage_gallery',
            'manage_articles',
            'manage_ads',
            'manage_landing_pages',
            'manage_settings',
        ]);

        $sales = Role::create(['name' => 'sales']);
        $sales->givePermissionTo([
            'manage_landing_pages',
            'manage_ads',
        ]);

        $operasional = Role::create(['name' => 'operasional']);
        $operasional->givePermissionTo([
            'manage_packages',
            'manage_jamaahs',
            'manage_groups',
            'manage_documents',
        ]);

        $finance = Role::create(['name' => 'finance']);
        $finance->givePermissionTo([
            'manage_payments',
            'manage_jamaahs',
        ]);

        // Assign superadmin role to the first user
        $user = User::first();
        if ($user) {
            $user->assignRole('superadmin');
        }
    }
}
