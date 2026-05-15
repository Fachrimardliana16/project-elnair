@extends('admin.layouts.app')
@section('title', 'Add Role')
@section('page_title', 'Add New Role')

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Role Name</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. manager">
        </div>
        <div class="form-group">
            <label>Permissions</label>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                @foreach($permissions as $permission)
                <label style="font-weight: 400; display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"> {{ str_replace('_', ' ', ucfirst($permission->name)) }}
                </label>
                @endforeach
            </div>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Save Role</button>
            <a href="{{ route('admin.roles.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
