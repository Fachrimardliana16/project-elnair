@extends('admin.layouts.app')
@section('title', 'New Article')
@section('page_title', 'Create New Article')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="article-form">
        @csrf
        <div class="form-group">
            <label>Title <span style="color:#dc3545;">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Content <span style="color:#dc3545;">*</span></label>
            {{-- Hidden textarea that gets submitted --}}
            <textarea name="content" id="content-input" class="@error('content') is-invalid @enderror" style="display:none;">{{ old('content') }}</textarea>
            {{-- Quill editor container --}}
            <div id="quill-editor" style="min-height: 300px; border: 1px solid #dee2e6; border-radius: 6px;"></div>
            @error('content') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="grid-2" style="gap: 1.5rem;">
            <div class="form-group">
                <label>Thumbnail Image</label>
                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                @error('thumbnail') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                <small style="color:#888; font-size:0.8rem;">Format: JPG, PNG, WebP. Maks: 2MB</small>
            </div>
            <div class="form-group">
                <label>Status <span style="color:#dc3545;">*</span></label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
        </div>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin">Publish Article</button>
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

    // Pre-fill with old content if available (e.g., on validation failure)
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
