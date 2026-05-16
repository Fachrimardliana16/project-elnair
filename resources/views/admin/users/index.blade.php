@extends('admin.layouts.app')
@section('title', 'Manage Users')
@section('page_title', 'Manage Users')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="margin: 0;">User List</h3>
        <a href="{{ route('admin.users.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Add New User</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span style="background: var(--brand-dark); color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; margin-right: 4px;">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" style="color: #4a90e2;"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
