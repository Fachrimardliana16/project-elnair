@extends('admin.layouts.app')
@section('title', 'Edit Article')
@section('page_title', 'Edit Article: ' . $article->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $article->title) }}">
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="10" required>{{ old('content', $article->content) }}</textarea>
        </div>
        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Thumbnail Image</label>
                <input type="file" name="thumbnail" class="form-control">
                @if($article->thumbnail)
                    <img src="{{ asset($article->thumbnail) }}" style="width: 150px; height: 80px; object-fit: cover; border-radius: 8px; margin-top: 1rem;">
                @endif
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="published" {{ $article->status === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ $article->status === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Update Article</button>
            <a href="{{ route('admin.articles.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
