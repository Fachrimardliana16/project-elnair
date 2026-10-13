<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdminRbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (['manage_landing_pages', 'manage_payments', 'manage_users', 'view_logs', 'manage_promos', 'manage_workflows'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::firstOrCreate(['name' => 'sales'])->syncPermissions(['manage_landing_pages']);
        Role::firstOrCreate(['name' => 'finance'])->syncPermissions(['manage_payments']);
        Role::firstOrCreate(['name' => 'marketing'])->syncPermissions(['manage_promos']);
        Role::firstOrCreate(['name' => 'operasional'])->syncPermissions(['manage_workflows']);
        Role::firstOrCreate(['name' => 'admin'])->syncPermissions(['manage_promos', 'manage_workflows']);
        Role::firstOrCreate(['name' => 'superadmin'])->syncPermissions(Permission::all());
    }

    public function test_marketing_can_access_promos_but_not_workflows(): void
    {
        $marketing = User::factory()->create();
        $marketing->assignRole('marketing');

        $this->actingAs($marketing)->get(route('admin.promos.index'))->assertOk();
        $this->actingAs($marketing)->get(route('admin.workflows.index'))->assertForbidden();
    }

    public function test_operasional_can_access_workflows_but_not_promos(): void
    {
        $operasional = User::factory()->create();
        $operasional->assignRole('operasional');

        $this->actingAs($operasional)->get(route('admin.workflows.index'))->assertOk();
        $this->actingAs($operasional)->get(route('admin.promos.index'))->assertForbidden();
    }

    public function test_admin_can_access_both_promos_and_workflows(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)->get(route('admin.promos.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.workflows.index'))->assertOk();
    }

    public function test_sales_cannot_access_users_payments_or_logs(): void
    {
        $sales = User::factory()->create();
        $sales->assignRole('sales');

        $this->actingAs($sales)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($sales)->get(route('admin.payments.index'))->assertForbidden();
        $this->actingAs($sales)->delete(route('admin.logs.clear'))->assertForbidden();
    }

    public function test_finance_can_access_payments_but_not_users(): void
    {
        $finance = User::factory()->create();
        $finance->assignRole('finance');

        $this->actingAs($finance)->get(route('admin.payments.index'))->assertOk();
        $this->actingAs($finance)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_superadmin_can_access_protected_admin_routes(): void
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('superadmin');

        $this->actingAs($superadmin)->get(route('admin.users.index'))->assertOk();
        $this->actingAs($superadmin)->get(route('admin.payments.index'))->assertOk();
    }
}
