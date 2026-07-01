@extends('admin.layouts.app')

@section('title', 'Website Settings')
@section('page_title', 'Global Website Branding & Payment Settings')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid-2">
            <div>
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-palette"></i> Branding</h3>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Site Name</label>
                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Website Logo</label>
                    <input type="file" name="logo" class="form-control">
                    @if(isset($settings['logo']))
                        <div style="margin-top: 1rem; background: #eee; padding: 1rem; border-radius: 8px;">
                            <img src="{{ asset($settings['logo']) }}" style="height: 50px; width: auto;">
                        </div>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Favicon</label>
                    <input type="file" name="favicon" class="form-control">
                    @if(isset($settings['favicon']))
                        <div style="margin-top: 1rem; background: #eee; padding: 1rem; border-radius: 8px;">
                            <img src="{{ asset($settings['favicon']) }}" style="height: 30px; width: auto;">
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-certificate"></i> Dokumen Perizinan & Legalitas</h3>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Nama PT Legal (Perusahaan)</label>
                    <input type="text" name="company_legal_name" class="form-control" value="{{ $settings['company_legal_name'] ?? '' }}" placeholder="Contoh: PT Elnair Sentra Wisata">
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Deskripsi Legalitas Singkat</label>
                    <textarea name="legal_description" class="form-control" rows="2" placeholder="Legalitas dan perizinan resmi perusahaan sebagai komitmen...">{{ $settings['legal_description'] ?? '' }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Nomor PPIU</label>
                    <input type="text" name="ppiu_number" class="form-control" value="{{ $settings['ppiu_number'] ?? '' }}" placeholder="Contoh: (On Process) atau No. 123 Tahun 2024">
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Nomor Izin Kemenag</label>
                    <input type="text" name="kemenag_license" class="form-control" value="{{ $settings['kemenag_license'] ?? '' }}" placeholder="Contoh: (On Process) atau No. 456 Tahun 2024">
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Nomor Induk Berusaha (NIB)</label>
                    <input type="text" name="nib_number" class="form-control" value="{{ $settings['nib_number'] ?? '' }}" placeholder="Contoh: 1909240160665">
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">Info Terbit NIB (Lokasi & Tanggal)</label>
                    <input type="text" name="nib_date" class="form-control" value="{{ $settings['nib_date'] ?? '' }}" placeholder="Contoh: Terbit: Jakarta, 19 September 2024">
                </div>
                <div class="form-group mb-3">
                    <label style="font-weight: 600;">URL Scan Bukti / Link Siskopatuh Kemenag</label>
                    <input type="text" name="ppiu_url" class="form-control" value="{{ $settings['ppiu_url'] ?? '' }}" placeholder="https://simpu.kemenag.go.id/...">
                </div>
            </div>
        </div>

        <div style="margin-top: 2.5rem; border-top: 1px solid #eee; padding-top: 2rem;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-address-book"></i> Kontak Utama & Media Sosial</h3>
            <div class="grid-2">
                <div>
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
                        <label style="font-weight: 600;">Jam Operasional</label>
                        <textarea name="operational_hours" class="form-control" rows="2" placeholder="Senin - Jumat: 09:00 - 17:00&#10;Sabtu: 09:00 - 14:00">{{ $settings['operational_hours'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Google Maps Embed URL (Iframe Src)</label>
                        <input type="text" name="google_maps_url" class="form-control" value="{{ $settings['google_maps_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=...">
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2.5rem; border-top: 1px solid #eee; padding-top: 2rem;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-credit-card"></i> Payment Gateway (Midtrans)</h3>
            <div class="grid-2">
                <div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Midtrans Merchant ID</label>
                        <input type="text" name="midtrans_merchant_id" class="form-control" value="{{ $settings['midtrans_merchant_id'] ?? '' }}" placeholder="Contoh: M123456">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Midtrans Client Key</label>
                        <input type="text" name="midtrans_client_key" class="form-control" value="{{ $settings['midtrans_client_key'] ?? '' }}" placeholder="SB-Mid-client-...">
                    </div>
                </div>
                <div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Midtrans Server Key</label>
                        <input type="text" name="midtrans_server_key" class="form-control" value="{{ $settings['midtrans_server_key'] ?? '' }}" placeholder="SB-Mid-server-...">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Environment Mode</label>
                        <select name="midtrans_environment" class="form-control">
                            <option value="sandbox" {{ ($settings['midtrans_environment'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox (Mode Testing / Uji Coba)</option>
                            <option value="production" {{ ($settings['midtrans_environment'] ?? 'sandbox') == 'production' ? 'selected' : '' }}>Production (Mode Live / Riil)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Homepage Section Visibility Controls -->
        <style>
        .section-control-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 1.25rem 1.5rem;
            border-radius: 12px;
            border: 1px solid #eef2f3;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .section-control-card:hover {
            border-color: var(--brand-teal);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13,76,84,0.05);
        }
        .section-control-card.feature-card:hover {
            border-color: var(--brand-gold);
            box-shadow: 0 8px 20px rgba(139, 94, 60, 0.05);
        }
        .section-card-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(102, 165, 173, 0.1);
            color: var(--brand-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .section-card-icon.gold-icon {
            background: rgba(139, 94, 60, 0.1);
            color: var(--brand-gold);
        }
        .section-card-label {
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
            margin: 0;
            cursor: pointer;
            user-select: none;
        }
        .section-card-sublabel {
            font-size: 0.75rem;
            color: #777;
            display: block;
            margin-top: 2px;
        }

        /* Switch styling */
        .premium-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
        }
        .premium-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .switch-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 34px;
        }
        .switch-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .premium-switch input:checked + .switch-slider {
            background-color: #66A5AD; /* Hardcoded Brand Teal for Admin Panel reliability */
        }
        .premium-switch input:checked + .switch-slider.gold-slider {
            background-color: #8B5E3C; /* Hardcoded Brand Gold for Admin Panel reliability */
        }
        .premium-switch input:checked + .switch-slider:before {
            transform: translateX(22px);
        }
        </style>

        <div style="margin-top: 2.5rem; border-top: 1px solid #eee; padding-top: 2rem;">
            <h3 style="margin-bottom: 0.5rem; font-size: 1.1rem; color: var(--brand-dark);"><i class="fas fa-toggle-on"></i> Homepage Section Controls (Aktifkan / Nonaktifkan Section Beranda)</h3>
            <p style="font-size: 0.85rem; color: #666; margin-bottom: 1.5rem;">Gunakan tombol toggle di bawah ini untuk menampilkan atau menyembunyikan bagian beranda secara instan.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem;">
                
                <!-- Hero Banner -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-image"></i></div>
                        <div>
                            <label for="show_hero_section" class="section-card-label">Hero Banner</label>
                            <span class="section-card-sublabel">Header utama beranda</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_hero_section" id="show_hero_section" value="1" {{ ($settings['show_hero_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Kenapa Memilih Kami -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-award"></i></div>
                        <div>
                            <label for="show_experience_section" class="section-card-label">Kenapa Memilih Kami</label>
                            <span class="section-card-sublabel">Keunggulan & legalitas PPIU</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_experience_section" id="show_experience_section" value="1" {{ ($settings['show_experience_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Jadwal Keberangkatan -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div>
                            <label for="show_schedule_section" class="section-card-label">Jadwal Keberangkatan</label>
                            <span class="section-card-sublabel">Kalender rencana perjalanan</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_schedule_section" id="show_schedule_section" value="1" {{ ($settings['show_schedule_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Paket Ibadah Unggulan -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-kaaba"></i></div>
                        <div>
                            <label for="show_packages_section" class="section-card-label">Paket Ibadah Unggulan</label>
                            <span class="section-card-sublabel">Katalog produk Haji & Umroh</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_packages_section" id="show_packages_section" value="1" {{ ($settings['show_packages_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Artikel & Berita Terbaru -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-newspaper"></i></div>
                        <div>
                            <label for="show_articles_section" class="section-card-label">Artikel & Berita</label>
                            <span class="section-card-sublabel">Kumpulan publikasi & berita</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_articles_section" id="show_articles_section" value="1" {{ ($settings['show_articles_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Testimonial Jamaah -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-quote-left"></i></div>
                        <div>
                            <label for="show_testimonials_section" class="section-card-label">Testimonial Jamaah</label>
                            <span class="section-card-sublabel">Ulasan kisah nyata jamaah</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_testimonials_section" id="show_testimonials_section" value="1" {{ ($settings['show_testimonials_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- FAQ Section -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-question-circle"></i></div>
                        <div>
                            <label for="show_faqs_section" class="section-card-label">Pusat Bantuan (FAQ)</label>
                            <span class="section-card-sublabel">Tanya Jawab Seputar Umroh</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_faqs_section" id="show_faqs_section" value="1" {{ ($settings['show_faqs_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Lokasi Kantor & Maps -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-map-marked-alt"></i></div>
                        <div>
                            <label for="show_location_section" class="section-card-label">Lokasi Kantor</label>
                            <span class="section-card-sublabel">Alamat lengkap & Google Maps</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_location_section" id="show_location_section" value="1" {{ ($settings['show_location_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Call to Action (CTA) -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-bullhorn"></i></div>
                        <div>
                            <label for="show_cta_section" class="section-card-label">Call to Action (CTA)</label>
                            <span class="section-card-sublabel">Blok konsultasi WhatsApp</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_cta_section" id="show_cta_section" value="1" {{ ($settings['show_cta_section'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Widget WA Floating -->
                <div class="section-control-card">
                    <div class="section-card-info">
                        <div class="section-card-icon"><i class="fas fa-comment-dots"></i></div>
                        <div>
                            <label for="show_sticky_cta_bar" class="section-card-label">Widget WA Floating</label>
                            <span class="section-card-sublabel">"Tim kami online sekarang"</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_sticky_cta_bar" id="show_sticky_cta_bar" value="1" {{ ($settings['show_sticky_cta_bar'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Fitur Pendaftaran Online (Gold Card Highlight) -->
                <div class="section-control-card feature-card" style="background: rgba(139, 94, 60, 0.02); border: 1px solid rgba(139, 94, 60, 0.15);">
                    <div class="section-card-info">
                        <div class="section-card-icon gold-icon"><i class="fas fa-user-plus"></i></div>
                        <div>
                            <label for="show_pendaftaran_feature" class="section-card-label" style="color: var(--brand-gold);">Pendaftaran Online</label>
                            <span class="section-card-sublabel">Halaman pendaftaran & button</span>
                        </div>
                    </div>
                    <label class="premium-switch">
                        <input type="checkbox" name="show_pendaftaran_feature" id="show_pendaftaran_feature" value="1" {{ ($settings['show_pendaftaran_feature'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider gold-slider"></span>
                    </label>
                </div>

            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn-admin" style="padding: 10px 24px; font-weight: 600; border-radius: 6px;"><i class="fas fa-save"></i> Save Website Settings</button>
        </div>
    </form>
</div>
@endsection
