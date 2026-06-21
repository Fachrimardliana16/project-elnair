@extends('admin.layouts.app')

@section('title', 'Marketing Settings')
@section('page_title', 'Global Marketing, Pixel & CRM Settings')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.marketing-settings.update') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
            <div>
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-address-book"></i> Kontak Utama & Media Sosial</h3>
                <div class="grid-2">
                    <div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600;">WhatsApp Numbers (Pisahkan dengan koma untuk fitur Rotator CS)</label>
                            <input type="text" name="wa_number" class="form-control" value="{{ $settings['wa_number'] ?? '' }}" placeholder="Contoh: 628111, 628222, 628333">
                            <small style="color: #64748b; font-size: 0.72rem; display: block; margin-top: 3px;">
                                <i class="fas fa-info-circle"></i> Angka wajib diawali kode negara (62).
                            </small>
                        </div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600;">Email Perusahaan</label>
                            <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}" placeholder="info@elnairtravel.com">
                        </div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600;">Nomor Telepon Kantor (Opsional)</label>
                            <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}" placeholder="(021) 1234 5678">
                        </div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600;">Instagram URL</label>
                            <input type="text" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] ?? '' }}">
                        </div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600;">Facebook URL</label>
                            <input type="text" name="facebook_url" class="form-control" value="{{ $settings['facebook_url'] ?? '' }}">
                        </div>
                    </div>
                    <div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600;">Alamat Kantor Utama</label>
                            <textarea name="address" class="form-control" rows="2">{{ $settings['address'] ?? '' }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label style="font-weight: 600;">Google Maps Embed URL (Iframe Src)</label>
                            <input type="text" name="google_maps_url" class="form-control" value="{{ $settings['google_maps_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2.5rem; border-top: 1px solid #eee; padding-top: 2rem;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-bullhorn"></i> Integrasi Iklan & SEO Engine</h3>
            <div class="grid-2">
                <div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Google Analytics / Tag Manager Script</label>
                        <textarea name="google_analytics" class="form-control" rows="5" placeholder="<!-- Paste your GA script here -->">{{ $settings['google_analytics'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Facebook Pixel Script (Browser-Side)</label>
                        <textarea name="facebook_pixel" class="form-control" rows="5" placeholder="<!-- Paste your FB Pixel script here -->">{{ $settings['facebook_pixel'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group mb-3" style="margin-top: 1.5rem;">
                        <label style="font-weight: 600;">Facebook Pixel ID (Untuk Server-Side CAPI)</label>
                        <input type="text" name="facebook_pixel_id" class="form-control" value="{{ $settings['facebook_pixel_id'] ?? '' }}" placeholder="Contoh: 123456789012345">
                    </div>
                    <div class="form-group mb-3" style="margin-top: 1.5rem;">
                        <label style="font-weight: 600;">Meta Conversions API (CAPI) Access Token</label>
                        <textarea name="facebook_capi_token" class="form-control" rows="4" placeholder="EAABw... (Token diawali dengan EAAB...)">{{ $settings['facebook_capi_token'] ?? '' }}</textarea>
                        <small style="color: #64748b; font-size: 0.72rem; display: block; margin-top: 5px;">
                            <i class="fas fa-info-circle"></i> Token ini dibuat melalui menu <strong>Events Manager &gt; Settings &gt; Generate access token</strong> di Facebook Business Suite Anda.
                        </small>
                    </div>
                </div>
                <div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">SEO Meta Keywords (Pisahkan dengan koma)</label>
                        <input type="text" name="meta_keywords" class="form-control" value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="umrah, travel, haji, jakarta">
                    </div>
                    <div class="form-group mb-3" style="margin-top: 1.5rem;">
                        <label style="font-weight: 600;">SEO Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="4" placeholder="Brief description of your website for Google search results...">{{ $settings['meta_description'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group mb-3" style="margin-top: 1.5rem;">
                        <label style="font-weight: 600;">Google Tag Manager (GTM) Container ID</label>
                        <input type="text" name="gtm_id" class="form-control" value="{{ $settings['gtm_id'] ?? '' }}" placeholder="Contoh: GTM-XXXXXX">
                    </div>
                    <div class="form-group mb-3" style="margin-top: 1.5rem;">
                        <label style="font-weight: 600;">TikTok Pixel ID (Browser & Server CAPI)</label>
                        <input type="text" name="tiktok_pixel_id" class="form-control" value="{{ $settings['tiktok_pixel_id'] ?? '' }}" placeholder="Contoh: C1234567890ABC">
                    </div>
                    <div class="form-group mb-3" style="margin-top: 1.5rem;">
                        <label style="font-weight: 600;">TikTok CAPI Access Token</label>
                        <input type="text" name="tiktok_capi_token" class="form-control" value="{{ $settings['tiktok_capi_token'] ?? '' }}" placeholder="Contoh: 1234567890abcdef...">
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2.5rem; border-top: 1px solid #eee; padding-top: 2rem;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-comment-dots"></i> WhatsApp CRM Follow-Up Templates</h3>
            <div class="form-group mb-3">
                <label style="font-weight: 600;">Template Pesan Tindak Lanjut CS (Follow-Up)</label>
                <textarea name="wa_followup_template" class="form-control" rows="4" placeholder="Tulis template pesan follow-up di sini...">{{ $settings['wa_followup_template'] ?? "Halo {name}, kami mendeteksi Anda tertarik dengan {package} di website Elnair. Apakah ada yang bisa kami bantu mengenai pendaftaran atau pilihan jadwalnya? 😊" }}</textarea>
                <small style="color: #64748b; font-size: 0.72rem; display: block; margin-top: 5px;">
                    <i class="fas fa-info-circle"></i> Gunakan variabel penampung berikut: <strong><code>{name}</code></strong> (diganti nama calon leads) dan <strong><code>{package}</code></strong> (diganti nama paket pilihan).
                </small>
            </div>
        </div>
        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn-admin" style="padding: 10px 24px; font-weight: 600; border-radius: 6px;"><i class="fas fa-save"></i> Save Marketing Settings</button>
        </div>
    </form>
</div>
@endsection
