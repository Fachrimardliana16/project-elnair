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
            'manage_guides',
            'manage_faqs',
            'manage_schedules',
            'view_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin']);
        $superAdmin->syncPermissions(Permission::all());

        $owner = Role::firstOrCreate(['name' => 'owner']);
        $owner->syncPermissions(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
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

        $marketing = Role::firstOrCreate(['name' => 'marketing']);
        $marketing->syncPermissions([
            'manage_gallery',
            'manage_articles',
            'manage_ads',
            'manage_landing_pages',
            'manage_settings',
        ]);

        $sales = Role::firstOrCreate(['name' => 'sales']);
        $sales->syncPermissions([
            'manage_landing_pages',
            'manage_ads',
        ]);

        $operasional = Role::firstOrCreate(['name' => 'operasional']);
        $operasional->syncPermissions([
            'manage_packages',
            'manage_jamaahs',
            'manage_groups',
            'manage_documents',
        ]);

        $finance = Role::firstOrCreate(['name' => 'finance']);
        $finance->syncPermissions([
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
