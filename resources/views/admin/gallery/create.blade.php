@extends('admin.layouts.app')
@section('title', 'Add Image')
@section('page_title', 'Add Image to Gallery')

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" class="form-control" placeholder="e.g. Umroh, Haji, Activity">
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Upload Image</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
