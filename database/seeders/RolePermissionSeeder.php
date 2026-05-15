<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

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
            'view_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $superAdmin = Role::create(['name' => 'superadmin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'manage_hero',
            'manage_features',
            'manage_packages',
            'manage_testimonials',
            'manage_settings',
            'manage_gallery',
            'manage_articles',
        ]);

        $marketing = Role::create(['name' => 'marketing']);
        $marketing->givePermissionTo([
            'manage_gallery',
            'manage_articles',
            'manage_ads',
            'manage_landing_pages',
        ]);

        // Assign superadmin role to the first user
        $user = User::first();
        if ($user) {
            $user->assignRole('superadmin');
        }
    }
}
