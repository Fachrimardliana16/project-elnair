@extends('admin.layouts.app')
@section('title', 'Manage Roles')
@section('page_title', 'Manage Roles')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="margin: 0;">Role List</h3>
        <a href="{{ route('admin.roles.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Add New Role</a>
    </div>

    @php
        $permissionLabels = [
            'manage_users' => 'Manajemen User',
            'manage_roles' => 'Role & Izin',
            'manage_hero' => 'Hero Section',
            'manage_features' => 'Keunggulan',
            'manage_packages' => 'Paket Umrah/Haji',
            'manage_promos' => 'Promo & Offering',
            'manage_workflows' => 'Alur Kerja (Workflow)',
            'manage_schedules' => 'Jadwal Keberangkatan',
            'manage_guides' => 'Pembimbing',
            'manage_testimonials' => 'Testimoni',
            'manage_faqs' => 'Kelola FAQ',
            'manage_settings' => 'Pengaturan Web',
            'manage_gallery' => 'Galeri',
            'manage_articles' => 'Artikel & Blog',
            'manage_ads' => 'Marketing Ads',
            'manage_landing_pages' => 'Landing Pages',
            'manage_jamaahs' => 'Pendaftar Jamaah',
            'manage_groups' => 'Rombongan Jemaah',
            'manage_payments' => 'Kelola Pembayaran',
            'manage_documents' => 'Berkas & Visa',
            'view_logs' => 'Error Logs',
        ];
    @endphp

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td><strong>{{ ucfirst($role->name) }}</strong></td>
                    <td>
                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                            @foreach($role->permissions as $permission)
                                <span style="background: #eef2f5; color: #334e68; padding: 2px 7px; border-radius: 4px; font-size: 0.72rem; border: 1px solid #d9e2ec;" title="{{ $permission->name }}">
                                    {{ $permissionLabels[$permission->name] ?? str_replace('_', ' ', ucfirst($permission->name)) }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.roles.edit', $role->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                            @if($role->name !== 'superadmin')
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
