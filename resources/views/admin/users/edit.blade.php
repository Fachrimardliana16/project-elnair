@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('page_title', 'Edit User: ' . $user->name)

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name <span style="color:#dc3545;">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name', $user->name) }}">
            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Email <span style="color:#dc3545;">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email', $user->email) }}">
            @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Password <span style="color:#888; font-size:0.8rem;">(Kosongkan untuk tetap menggunakan password saat ini)</span></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>
        <div class="form-group">
            <label>Roles <span style="color:#dc3545;">*</span></label>
            <div style="display: flex; flex-direction: column; gap: 0.5rem; padding: 1rem; border: 1px solid #ddd; border-radius: 8px; @error('roles') border-color: #dc3545; @enderror">
                @foreach($roles as $role)
                <label style="font-weight: 400; display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                        {{ in_array($role->name, old('roles', $user->getRoleNames()->toArray())) ? 'checked' : '' }}>
                    {{ ucfirst($role->name) }}
                </label>
                @endforeach
            </div>
            @error('roles') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
