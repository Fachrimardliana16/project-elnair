@extends('admin.layouts.app')
@section('title', 'New Ad')
@section('page_title', 'Create Marketing Ad')

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Ad Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Target Link (URL)</label>
            <input type="url" name="link" class="form-control" required placeholder="https://...">
        </div>
        <div class="form-group">
            <label>Ad Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="is_active" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Save Ad</button>
            <a href="{{ route('admin.ads.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
