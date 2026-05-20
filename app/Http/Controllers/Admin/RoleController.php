<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();
        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();
        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'superadmin') {
            return back()->with('error', 'Superadmin role cannot be deleted.');
        }
        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }
}
