@extends('admin.layouts.app')
@section('title', 'Edit Article')
@section('page_title', 'Edit Article: ' . $article->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="article-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Title <span style="color:#dc3545;">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title', $article->title) }}">
            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Content <span style="color:#dc3545;">*</span></label>
            {{-- Hidden textarea that gets submitted --}}
            <textarea name="content" id="content-input" class="@error('content') is-invalid @enderror" style="display:none;">{{ old('content', $article->content) }}</textarea>
            {{-- Quill editor container --}}
            <div id="quill-editor" style="min-height: 300px; border: 1px solid #dee2e6; border-radius: 6px;"></div>
            @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="grid-2" style="gap: 1.5rem;">
            <div class="form-group">
                <label>Thumbnail Image</label>
                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                @error('thumbnail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                @if($article->thumbnail)
                    <img src="{{ asset($article->thumbnail) }}" style="width: 150px; height: 80px; object-fit: cover; border-radius: 8px; margin-top: 1rem; border:1px solid #ddd;">
                    <p style="font-size:0.8rem; color:#888; margin-top:0.3rem;">Upload baru untuk mengganti.</p>
                @endif
            </div>
            <div class="form-group">
                <label>Status <span style="color:#dc3545;">*</span></label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin">Update Article</button>
            <a href="{{ route('admin.articles.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>

{{-- Quill.js CDN --}}
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tulis isi artikel di sini...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote', 'code-block'],
                ['link'],
                [{ 'align': [] }],
                ['clean']
            ]
        }
    });

    // Pre-fill editor with existing article content
    var existingContent = document.getElementById('content-input').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // On submit: copy Quill HTML into the hidden textarea
    document.getElementById('article-form').addEventListener('submit', function () {
        document.getElementById('content-input').value = quill.root.innerHTML;
    });
</script>
@endsection

