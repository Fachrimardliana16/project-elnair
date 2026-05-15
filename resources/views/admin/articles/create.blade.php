@extends('admin.layouts.app')
@section('title', 'New Article')
@section('page_title', 'Create New Article')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="10" required></textarea>
        </div>
        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Thumbnail Image</label>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Publish Article</button>
            <a href="{{ route('admin.articles.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
