@extends('admin.layouts.app')

@section('title', 'Website Settings')
@section('page_title', 'Global Website Settings')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);">Branding</h3>
                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Website Logo</label>
                    <input type="file" name="logo" class="form-control">
                    @if(isset($settings['logo']))
                        <div style="margin-top: 1rem; background: #eee; padding: 1rem; border-radius: 8px;">
                            <img src="{{ asset($settings['logo']) }}" style="height: 50px; width: auto;">
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Favicon</label>
                    <input type="file" name="favicon" class="form-control">
                </div>
            </div>
            <div>
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);">Contact & Social</h3>
                <div class="form-group">
                    <label>WhatsApp Number (e.g. 628123456789)</label>
                    <input type="text" name="wa_number" class="form-control" value="{{ $settings['wa_number'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Instagram URL</label>
                    <input type="text" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Facebook URL</label>
                    <input type="text" name="facebook_url" class="form-control" value="{{ $settings['facebook_url'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Office Address</label>
                    <textarea name="address" class="form-control" rows="3">{{ $settings['address'] ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Google Maps Embed URL (Iframe Src)</label>
                    <input type="text" name="google_maps_url" class="form-control" value="{{ $settings['google_maps_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=...">
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; border-top: 1px solid #eee; padding-top: 2rem;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);">Marketing & SEO</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <div class="form-group">
                        <label>Google Analytics / Tag Manager Script</label>
                        <textarea name="google_analytics" class="form-control" rows="5" placeholder="<!-- Paste your GA script here -->">{{ $settings['google_analytics'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Facebook Pixel Script</label>
                        <textarea name="facebook_pixel" class="form-control" rows="5" placeholder="<!-- Paste your FB Pixel script here -->">{{ $settings['facebook_pixel'] ?? '' }}</textarea>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>SEO Meta Keywords (Separated by commas)</label>
                        <input type="text" name="meta_keywords" class="form-control" value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="umrah, travel, haji, jakarta">
                    </div>
                    <div class="form-group">
                        <label>SEO Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="4" placeholder="Brief description of your website for Google search results...">{{ $settings['meta_description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 1rem; text-align: right;">
            <button type="submit" class="btn-admin"><i class="fas fa-save"></i> Update Settings</button>
        </div>
    </form>
</div>
@endsection
