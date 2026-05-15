@extends('admin.layouts.app')
@section('title', 'Edit Image')
@section('page_title', 'Edit Gallery Image')

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $gallery->title) }}">
        </div>
        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $gallery->category) }}">
        </div>
        <div class="form-group">
            <label>Image (Leave blank to keep current)</label>
            <input type="file" name="image" class="form-control">
            @if($gallery->image)
                <img src="{{ asset($gallery->image) }}" style="width: 200px; height: 120px; object-fit: cover; border-radius: 8px; margin-top: 1rem; border: 1px solid #eee;">
            @endif
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Update Image</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
