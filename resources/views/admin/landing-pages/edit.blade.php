@extends('admin.layouts.app')
@section('title', 'Edit Landing Page')
@section('page_title', 'Edit Sales Landing Page: ' . $landingPage->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.landing-pages.update', $landingPage->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Page Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $landingPage->title) }}">
        </div>

        <div class="form-group">
            <label>Hero Image (WebP Optimized)</label>
            @if($landingPage->hero_image)
            <div style="margin-bottom: 10px;">
                <img src="{{ asset($landingPage->hero_image) }}" alt="Hero" style="height: 100px; border-radius: 8px;">
            </div>
            @endif
            <input type="file" name="hero_image" class="form-control" accept="image/*">
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Custom WhatsApp Number (Optional)</label>
                    <input type="text" name="custom_wa_number" class="form-control" value="{{ old('custom_wa_number', $landingPage->custom_wa_number) }}" placeholder="628123456789">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Custom WhatsApp Message</label>
                    <input type="text" name="custom_wa_message" class="form-control" value="{{ old('custom_wa_message', $landingPage->custom_wa_message) }}" placeholder="Halo Elnair, saya tertarik dengan promo...">
                </div>
            </div>
        </div>

        <hr style="margin: 2rem 0; border-top: 1px solid #eee;">
        <h5>Marketing & SEO Settings</h5>
        
        <div class="form-group">
            <label>Meta Title (SEO)</label>
            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $landingPage->meta_title) }}" placeholder="Meta title for social sharing">
        </div>

        <div class="form-group">
            <label>Meta Description (SEO)</label>
            <textarea name="meta_description" class="form-control" rows="3" placeholder="Brief summary for Google and social media">{{ old('meta_description', $landingPage->meta_description) }}</textarea>
        </div>

        <hr style="margin: 2rem 0; border-top: 1px solid #eee;">
        
        <div class="form-group">
            <label>Page Content (HTML support)</label>
            <textarea name="content" class="form-control" rows="15">{{ old('content', $landingPage->content) }}</textarea>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Update Landing Page</button>
            <a href="{{ route('admin.landing-pages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
