@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('page_title', 'Edit User: ' . $user->name)

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
        </div>
        <div class="form-group">
            <label>Password (Leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="form-group">
            <label>Roles</label>
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                @foreach($roles as $role)
                <label style="font-weight: 400; display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}> {{ ucfirst($role->name) }}
                </label>
                @endforeach
            </div>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
