@extends('admin.layouts.app')
@section('title', 'New Landing Page')
@section('page_title', 'Create Sales Landing Page')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.landing-pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Page Title</label>
            <input type="text" name="title" class="form-control" required placeholder="e.g. Promo Ramadhan 2024">
        </div>

        <div class="form-group">
            <label>Hero Image (WebP Optimized)</label>
            <input type="file" name="hero_image" class="form-control" accept="image/*">
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Custom WhatsApp Number (Optional)</label>
                    <input type="text" name="custom_wa_number" class="form-control" placeholder="628123456789 (leave blank for default)">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Custom WhatsApp Message</label>
                    <input type="text" name="custom_wa_message" class="form-control" placeholder="Halo Elnair, saya tertarik dengan promo...">
                </div>
            </div>
        </div>

        <hr style="margin: 2rem 0; border-top: 1px solid #eee;">
        <h5>Marketing & SEO Settings</h5>
        
        <div class="form-group">
            <label>Meta Title (SEO)</label>
            <input type="text" name="meta_title" class="form-control" placeholder="Meta title for social sharing">
        </div>

        <div class="form-group">
            <label>Meta Description (SEO)</label>
            <textarea name="meta_description" class="form-control" rows="3" placeholder="Brief summary for Google and social media"></textarea>
        </div>

        <hr style="margin: 2rem 0; border-top: 1px solid #eee;">
        
        <div class="form-group">
            <label>Page Content (HTML support)</label>
            <textarea name="content" class="form-control" rows="15" placeholder="Enter landing page content..."></textarea>
        </div>
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-admin">Create Landing Page</button>
            <a href="{{ route('admin.landing-pages.index') }}" class="btn-admin-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
