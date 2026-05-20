@extends('admin.layouts.app')
@section('title', 'Edit Feature')
@section('page_title', 'Edit Feature: ' . $feature->title)

@section('content')
<div class="admin-card" style="max-width: 600px;">
    <form action="{{ route('admin.features.update', $feature->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Icon (FontAwesome class) <span style="color:#dc3545;">*</span></label>
            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" required value="{{ old('icon', $feature->icon) }}">
            @error('icon') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Title <span style="color:#dc3545;">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title', $feature->title) }}">
            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Description <span style="color:#dc3545;">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $feature->description) }}</textarea>
            @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Order</label>
            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $feature->order) }}">
            @error('order') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn-admin">Update Feature</button>
            <a href="{{ route('admin.features.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
