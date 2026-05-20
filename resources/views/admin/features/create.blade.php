@extends('admin.layouts.app')
@section('title', 'Add Feature')
@section('page_title', 'Add New Feature')
@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.features.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Icon Class (FontAwesome) <span style="color:#dc3545;">*</span></label>
            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" placeholder="fas fa-check" value="{{ old('icon') }}" required>
            @error('icon') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <small style="color:#888; font-size:0.8rem;">Contoh: fas fa-kaaba, fas fa-plane, fas fa-heart</small>
        </div>
        <div class="form-group">
            <label>Title <span style="color:#dc3545;">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Description <span style="color:#dc3545;">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" required>{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
            @error('order') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin">Save Feature</button>
            <a href="{{ route('admin.features.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
