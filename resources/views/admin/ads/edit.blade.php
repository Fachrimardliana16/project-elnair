@extends('admin.layouts.app')
@section('title', 'Edit Ad')
@section('page_title', 'Edit Marketing Ad: ' . $ad->title)

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Ad Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $ad->title) }}">
        </div>
        <div class="form-group">
            <label>Target Link (URL)</label>
            <input type="url" name="link" class="form-control" required value="{{ old('link', $ad->link) }}">
        </div>
        <div class="form-group">
            <label>Ad Image (Leave blank to keep current)</label>
            <input type="file" name="image" class="form-control">
            @if($ad->image)
                <img src="{{ asset($ad->image) }}" style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px; margin-top: 1rem; border: 1px solid #eee;">
            @endif
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ $ad->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$ad->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Update Ad</button>
            <a href="{{ route('admin.ads.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
