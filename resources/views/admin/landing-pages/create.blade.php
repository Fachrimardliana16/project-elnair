@extends('admin.layouts.app')
@section('title', 'New Landing Page')
@section('page_title', 'Create Sales Landing Page')

@section('styles')
<link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
<style>
    #gjs {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    .gjs-cv-canvas {
        background-color: white;
    }
    .panel-control-btn {
        background: #fff;
        color: #0D4C54;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .panel-control-btn:hover {
        background: #0D4C54;
        color: #fff;
        border-color: #0D4C54;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(13,76,84,0.15);
    }
    .panel-control-btn i {
        font-size: 0.85rem;
    }

    /* GrapesJS UI Overrides for Premium Look (Elementor-style) */
    .gjs-block {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 15px 5px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
        transition: all 0.2s ease !important;
    }
    .gjs-block:hover {
        border-color: #0D4C54 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(13,76,84,0.1) !important;
    }
    /* Warna ikon di dalam Block */
    .gjs-block i {
        font-size: 1.8rem !important;
        color: #0D4C54 !important;
        margin-bottom: 5px;
    }
    .gjs-block-label {
        font-weight: 600 !important;
        font-size: 0.8rem !important;
        color: #333 !important;
        font-family: 'Outfit', sans-serif !important;
    }
    
    /* Panel Tabs dan Tombol Atas */
    .gjs-pn-panel {
        background-color: #ffffff !important;
        border-bottom: 1px solid #eee !important;
    }
    .gjs-pn-btn {
        color: #64748b !important;
    }
    .gjs-pn-btn.gjs-pn-active {
        color: #0D4C54 !important;
        background-color: #f1f5f9 !important;
        border-radius: 6px;
    }
    
    /* Panel Kanan (Layer/Style/Trait) */
    .gjs-sm-sector, .gjs-clm-tags, .gjs-trt-traits, .gjs-blocks-c, .gjs-pn-views-container {
        background-color: #f8f9fc !important;
    }
    .gjs-block-category .gjs-title {
        background-color: #e2e8f0 !important;
        color: #0D4C54 !important;
        font-weight: bold !important;
        border-bottom: 1px solid #cbd5e1 !important;
    }

    /* GRAPESJS LIGHT THEME TEXT FIXES - BRUTE FORCE */
    .gjs-pn-views-container, .gjs-pn-panels {
        color: #333 !important;
    }
    
    /* Sector Titles (General, Dimension, Typography, dll) */
    .gjs-sm-title, .gjs-sm-sector-title, .gjs-clm-tags-title, .gjs-layer-title, .gjs-trt-header, .gjs-trt-title {
        background-color: #e2e8f0 !important;
        color: #0D4C54 !important;
        border-bottom: 1px solid #cbd5e1 !important;
        text-shadow: none !important;
        font-weight: bold !important;
    }
    
    /* Label text (Classes, Selected:, Margin, Padding, dll) */
    .gjs-sm-label, .gjs-sm-property__label, .gjs-clm-label, .gjs-trt-label, .gjs-layer-name, .gjs-clm-header-status, .gjs-sm-name {
        color: #0D4C54 !important;
        text-shadow: none !important;
        font-weight: 600 !important;
    }
    
    /* Input fields and tags */
    .gjs-field, .gjs-clm-tags .gjs-clm-tag {
        background-color: #fff !important;
        color: #333 !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }
    .gjs-field input, .gjs-field select {
        color: #333 !important;
    }
    
    /* Plus icon in Classes */
    .gjs-clm-add {
        color: #0D4C54 !important;
    }
    
    .gjs-sm-clear {
        color: #94a3b8 !important;
    }
    
    /* Sub-properties (Top, Right, Bottom, Left for Margin/Padding) */
    .gjs-sm-property__top .gjs-sm-label, 
    .gjs-sm-property__right .gjs-sm-label, 
    .gjs-sm-property__bottom .gjs-sm-label, 
    .gjs-sm-property__left .gjs-sm-label {
        color: #64748b !important;
        font-weight: normal !important;
    }
    
    /* Device selector */
    .gjs-devices-c {
        color: #475569 !important;
    }
    .gjs-pn-commands .gjs-pn-btn, .gjs-pn-options .gjs-pn-btn {
        color: #0D4C54 !important;
    }
    
    /* Fix radio buttons in style manager (e.g. text-align) */
    .gjs-radio-item-label {
        color: #475569 !important;
        background: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
    }
    .gjs-radio-item input:checked + .gjs-radio-item-label {
        background: #0D4C54 !important;
        color: #fff !important;
    }
    
    /* Fix Empty State Text in Style Manager */
    .gjs-sm-empty, .gjs-clm-empty {
        color: #64748b !important;
    }
    
    /* Device Switcher (Desktop/Tablet/Mobile) Visibility */
    .gjs-devices-c .gjs-select {
        color: #0D4C54 !important;
        background-color: #fff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 4px;
        padding: 3px 5px;
        font-weight: 500;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
    <form action="{{ route('admin.landing-pages.store') }}" method="POST" enctype="multipart/form-data" id="landingPageForm">
        @csrf
        <div style="display: flex; gap: 0; align-items: stretch; height: calc(100vh - 120px); border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff;" id="main-workspace">
            <!-- LEFT PANEL (Form) -->
            <div id="left-form-panel" style="width: 300px; flex-shrink: 0; height: 100%; display: flex; flex-direction: column; border-right: 1px solid #ddd; transition: all 0.3s; overflow: hidden;">
                <!-- Panel Header -->
                <div style="padding: 15px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; background: #f8f9fc;">
                    <h5 style="margin: 0; font-size: 1rem; color: #0D4C54; font-weight: bold;"><i class="fas fa-sliders-h mr-2"></i> Pengaturan</h5>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="panel-control-btn" onclick="toggleMode('form')" id="btn-max-form" title="Maximize Form"><i class="fas fa-expand"></i></button>
                        <button type="button" class="panel-control-btn" onclick="toggleMode('builder')" id="btn-col-form" title="Collapse Form"><i class="fas fa-chevron-left"></i></button>
                    </div>
                </div>
                
                <!-- Panel Body -->
                <div style="padding: 15px; overflow-y: auto; flex-grow: 1;">
                    <h5 style="font-size: 1rem; color: #0D4C54; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Basic Info</h5>
                    
                    <div class="form-group mb-3">
                        <label style="font-size: 0.9rem;">Page Title <span style="color:#dc3545;">*</span></label>
                        <input type="text" name="title" class="form-control form-control-sm @error('title') is-invalid @enderror" required placeholder="e.g. Promo Ramadhan" value="{{ old('title') }}">
                        @error('title') <div class="invalid-feedback d-block" style="font-size:0.8rem;">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label style="font-size: 0.9rem;">URL Slug (Opsional)</label>
                        <input type="text" name="slug" class="form-control form-control-sm @error('slug') is-invalid @enderror" placeholder="promo-haji" value="{{ old('slug') }}">
                        @error('slug') <div class="invalid-feedback d-block" style="font-size:0.8rem;">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label style="font-size: 0.9rem;">Custom Domain (Opsional)</label>
                        <input type="text" name="custom_domain" class="form-control form-control-sm" placeholder="cth: promoelnair.info">
                        <small style="color: #64748b; font-size: 0.72rem; display: block; margin-top: 3px;">
                            <i class="fas fa-link"></i> Gunakan domain khusus murah untuk landing page ini. Cukup arahkan CNAME/A Record domain tersebut ke IP server Anda.
                        </small>
                    </div>

                    <div class="form-group mb-3">
                        <label style="font-size: 0.9rem;">Hero Image (WebP)</label>
                        <input type="file" name="hero_image" class="form-control form-control-sm" accept="image/*">
                    </div>

                    <h5 style="font-size: 1.1rem; color: #0D4C54; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; margin-top: 20px;">WhatsApp</h5>
                    
                    <div class="form-group mb-4">
                        <label style="font-size: 0.9rem; font-weight: bold; color: #0D4C54;">Custom WA Number (WhatsApp Rotator)</label>
                        <input type="text" name="custom_wa_number" class="form-control form-control-sm" placeholder="628123456789, 628987654321">
                        <small style="color: #64748b; font-size: 0.75rem; display: block; margin-top: 5px;">
                            <i class="fas fa-info-circle"></i> Masukkan satu nomor atau beberapa nomor dipisahkan koma (cth: <code>628123456, 628999888</code>) untuk membagi beban chat CS secara bergantian.
                        </small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label style="font-size: 0.9rem;">Custom WA Message</label>
                        <textarea name="custom_wa_message" class="form-control form-control-sm" rows="2" placeholder="Halo Elnair..."></textarea>
                    </div>

                    <h5 style="font-size: 1.1rem; color: #0D4C54; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; margin-top: 20px;">SEO & Marketing</h5>
                    
                    <div class="form-group mb-3">
                        <label style="font-size: 0.9rem;">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control form-control-sm" placeholder="Meta title">
                    </div>

                    <div class="form-group mb-3">
                        <label style="font-size: 0.9rem;">Meta Description</label>
                        <textarea name="meta_description" class="form-control form-control-sm" rows="3" placeholder="Brief summary..."></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label style="font-size: 0.9rem;">Custom HTML/Header Script (Global)</label>
                        <textarea name="pixel_script" class="form-control form-control-sm" rows="2" placeholder="<!-- Tambahan script HTML kustom mentah apa saja -->"></textarea>
                    </div>

                    <!-- Accordion Panel: Multi-Platform Pixel Settings -->
                    <div class="mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-top: 15px;">
                        <h6 style="font-size: 0.85rem; font-weight: bold; color: #0D4C54; margin: 0 0 12px 0; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-chart-line"></i> Pixel Tracking (Multi-Platform)
                        </h6>
                        
                        <!-- Facebook Accordion -->
                        <details style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 8px; overflow: hidden;">
                            <summary style="font-size: 0.8rem; font-weight: 600; padding: 8px 12px; color: #0D4C54; background: #f1f5f9; cursor: pointer; display: flex; justify-content: space-between; align-items: center; outline: none; list-style: none;">
                                <span><i class="fab fa-facebook" style="color: #1877f2; margin-right: 5px;"></i> Meta Ads (Facebook)</span>
                                <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                            </summary>
                            <div style="padding: 10px;">
                                <div class="form-group mb-2">
                                    <label style="font-size: 0.75rem; font-weight: bold; margin-bottom: 3px; display: block;">Meta Pixel ID</label>
                                    <input type="text" name="fb_pixel_id" class="form-control form-control-sm" placeholder="ID Pixel">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: bold; margin-bottom: 3px; display: block;">Meta CAPI Access Token</label>
                                    <textarea name="fb_capi_token" class="form-control form-control-sm" rows="2" placeholder="EAABw..."></textarea>
                                </div>
                            </div>
                        </details>

                        <!-- TikTok Accordion -->
                        <details style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 8px; overflow: hidden;">
                            <summary style="font-size: 0.8rem; font-weight: 600; padding: 8px 12px; color: #0D4C54; background: #f1f5f9; cursor: pointer; display: flex; justify-content: space-between; align-items: center; outline: none; list-style: none;">
                                <span><i class="fab fa-tiktok" style="color: #000000; margin-right: 5px;"></i> TikTok Ads</span>
                                <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                            </summary>
                            <div style="padding: 10px;">
                                <div class="form-group mb-2">
                                    <label style="font-size: 0.75rem; font-weight: bold; margin-bottom: 3px; display: block;">TikTok Pixel ID</label>
                                    <input type="text" name="tiktok_pixel_id" class="form-control form-control-sm" placeholder="ID Pixel TikTok">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: bold; margin-bottom: 3px; display: block;">TikTok CAPI Access Token</label>
                                    <textarea name="tiktok_capi_token" class="form-control form-control-sm" rows="2" placeholder="Token CAPI TikTok"></textarea>
                                </div>
                            </div>
                        </details>

                        <!-- Snack Video Accordion -->
                        <details style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 8px; overflow: hidden;">
                            <summary style="font-size: 0.8rem; font-weight: 600; padding: 8px 12px; color: #0D4C54; background: #f1f5f9; cursor: pointer; display: flex; justify-content: space-between; align-items: center; outline: none; list-style: none;">
                                <span><i class="fas fa-video" style="color: #ff5000; margin-right: 5px;"></i> Snack Video (Kwai)</span>
                                <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                            </summary>
                            <div style="padding: 10px;">
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: bold; margin-bottom: 3px; display: block;">Snack Video Pixel ID</label>
                                    <input type="text" name="snack_pixel_id" class="form-control form-control-sm" placeholder="ID Pixel Snack Video">
                                </div>
                            </div>
                        </details>

                        <!-- Google Ads Accordion -->
                        <details style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">
                            <summary style="font-size: 0.8rem; font-weight: 600; padding: 8px 12px; color: #0D4C54; background: #f1f5f9; cursor: pointer; display: flex; justify-content: space-between; align-items: center; outline: none; list-style: none;">
                                <span><i class="fab fa-google" style="color: #4285f4; margin-right: 5px;"></i> Google Ads Tracking</span>
                                <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                            </summary>
                            <div style="padding: 10px;">
                                <div class="form-group mb-2">
                                    <label style="font-size: 0.75rem; font-weight: bold; margin-bottom: 3px; display: block;">Google Tag ID</label>
                                    <input type="text" name="google_pixel_id" class="form-control form-control-sm" placeholder="AW-XXXXXXXXX">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: bold; margin-bottom: 3px; display: block;">Google Conversion Label</label>
                                    <input type="text" name="google_conversion_label" class="form-control form-control-sm" placeholder="Contoh: abcdEFGH1234">
                                </div>
                            </div>
                        </details>
                    </div>

                    <div class="form-group mb-4" id="pixel-events-container">
                        <label style="font-size: 0.9rem; font-weight: bold; color: #0D4C54; display: block; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Events Saat Landing Page Terbuka</label>
                        <div id="events-wrapper">
                            <!-- Event blocks akan masuk ke sini via JS -->
                        </div>
                        <button type="button" class="btn btn-sm" style="background: #e2e8f0; color: #0D4C54; width: 100%; margin-top: 10px; border-radius: 6px; font-weight: 600; padding: 8px;" onclick="addPixelEvent()">
                            <i class="fas fa-plus"></i> Tambah Event Meta
                        </button>
                    </div>
                    
                    <button type="submit" class="btn-admin w-100" style="margin-bottom: 10px;">Save Landing Page</button>
                    <a href="{{ route('admin.landing-pages.index') }}" class="btn-admin-outline w-100 text-center" style="display: block;">Cancel</a>
                </div>
            </div>

            <!-- RIGHT PANEL (GrapesJS) -->
            <div id="right-builder-panel" style="flex-grow: 1; height: 100%; display: flex; flex-direction: column; min-width: 0; transition: all 0.3s;">
                <!-- Panel Header -->
                <div style="padding: 15px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; background: #f8f9fc;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button type="button" class="panel-control-btn" onclick="toggleMode('split')" id="btn-restore-builder" style="display: none;" title="Tampilkan Form"><i class="fas fa-chevron-right"></i></button>
                        <h5 style="margin: 0; font-size: 1rem; color: #0D4C54; font-weight: bold;"><i class="fas fa-paint-brush mr-2"></i> Visual Builder</h5>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="panel-control-btn" onclick="toggleMode('builder')" id="btn-max-builder" title="Maximize Builder"><i class="fas fa-expand"></i></button>
                        <button type="button" class="panel-control-btn" onclick="toggleMode('split')" id="btn-col-builder" style="display: none;" title="Restore Builder"><i class="fas fa-compress"></i></button>
                    </div>
                </div>
                
                <!-- Panel Body -->
                <div style="flex-grow: 1; overflow: hidden; position: relative;">
                    <div id="gjs" style="height: 100%; width: 100%; border: none;"></div>
                    <textarea name="content" id="content-textarea" style="display: none;"></textarea>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script src="https://unpkg.com/grapesjs"></script>
<script src="https://unpkg.com/grapesjs-preset-webpage@1.0.2"></script>
<script src="https://unpkg.com/grapesjs-tabs@1.0.6"></script>
<script src="https://unpkg.com/grapesjs-custom-code@1.0.1"></script>
<script src="https://unpkg.com/grapesjs-tooltip@0.1.7"></script>

<script>
    const editor = grapesjs.init({
        container: '#gjs',
        height: '100%',
        width: '100%',
        storageManager: false,
        plugins: [
            'gjs-preset-webpage',
            'grapesjs-tabs',
            'grapesjs-custom-code',
            'grapesjs-tooltip'
        ],
        pluginsOpts: {
            'gjs-preset-webpage': {
                blocksBasicOpts: { flexGrid: true },
                // Aktifkan kembali semua fitur bawaan
                navbarOpts: true,
                countdownOpts: true,
                formsOpts: true,
                exportOpts: true,
                importOpts: true,
            }
        }
    });

    editor.on('load', function() {
        const pn = editor.Panels;
        const bm = editor.BlockManager;
        const domc = editor.DomComponents;

        // Custom Component: Heading dengan pilihan H1-H6
        domc.addType('heading', {
            extend: 'text',
            isComponent: el => el.tagName && ['H1','H2','H3','H4','H5','H6'].includes(el.tagName),
            model: {
                defaults: {
                    traits: [
                        'id',
                        'title',
                        {
                            type: 'select',
                            name: 'tagName',
                            label: 'HTML Tag',
                            options: [
                                { value: 'h1', name: 'H1' },
                                { value: 'h2', name: 'H2' },
                                { value: 'h3', name: 'H3' },
                                { value: 'h4', name: 'H4' },
                                { value: 'h5', name: 'H5' },
                                { value: 'h6', name: 'H6' },
                            ]
                        }
                    ]
                }
            }
        });
        
        // ==========================================
        // KATEGORI: ELEMENTOR WIDGETS
        // ==========================================
        bm.add('custom-container', {
            label: 'Inner Section',
            media: '<i class="fas fa-columns"></i>',
            content: '<div style="display: flex; gap: 20px; padding: 20px; min-height: 100px; border: 1px dashed #ccc;"><div style="flex: 1; padding: 10px;"></div><div style="flex: 1; padding: 10px;"></div></div>',
            category: 'Elementor Widgets',
        });
        bm.add('custom-heading', {
            label: 'Heading',
            media: '<i class="fas fa-heading"></i>',
            content: '<h2 style="font-family: \'Outfit\', sans-serif; color: #0D4C54;">Ketik Judul Di Sini</h2>',
            category: 'Elementor Widgets'
        });
        bm.add('custom-text', {
            label: 'Text Editor',
            media: '<i class="fas fa-align-left"></i>',
            content: '<p style="font-family: \'Outfit\', sans-serif; color: #333; line-height: 1.6;">Ketik paragraf atau deskripsi panjang di sini. Klik dua kali untuk mulai mengedit teks.</p>',
            category: 'Elementor Widgets'
        });
        bm.add('custom-button', {
            label: 'Button',
            media: '<i class="fas fa-link"></i>',
            content: '<a href="#" style="display: inline-block; padding: 12px 24px; background-color: #0D4C54; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; font-family: \'Outfit\', sans-serif; text-align: center;">Klik Di Sini</a>',
            category: 'Elementor Widgets'
        });
        bm.add('custom-media', {
            label: 'Image & Video',
            media: '<i class="fas fa-photo-video"></i>',
            content: `
            <div style="text-align: center; padding: 20px; background: #f8f9fc; border: 1px dashed #cbd5e1; border-radius: 8px;">
                <img src="https://via.placeholder.com/800x450?text=Klik+Dua+Kali+Untuk+Ganti+Gambar+Atau+Video" style="width: 100%; height: auto; border-radius: 8px;">
            </div>
            `,
            category: 'Elementor Widgets',
        });
        bm.add('custom-divider', {
            label: 'Divider & Spacer',
            media: '<i class="fas fa-minus"></i>',
            content: '<hr style="border: 0; border-top: 2px solid #DCD0C0; margin: 40px 0;">',
            category: 'Elementor Widgets',
        });
        bm.add('custom-map', {
            label: 'Google Maps',
            media: '<i class="fas fa-map-marker-alt"></i>',
            content: { type: 'map', style: { width: '100%', height: '350px' } },
            category: 'Elementor Widgets',
        });
        bm.add('custom-icon-box', {
            label: 'Icon & Icon Box',
            media: '<i class="fas fa-star"></i>',
            content: `
            <div style="text-align: center; padding: 20px; font-family: 'Outfit', sans-serif;">
                <div style="font-size: 40px; color: #8B5E3C; margin-bottom: 15px;"><i class="fas fa-star"></i></div>
                <h3 style="color: #0D4C54; margin-bottom: 10px;">Pelayanan Bintang 5</h3>
                <p style="color: #666;">Deskripsi singkat mengenai layanan unggulan Anda.</p>
            </div>
            `,
            category: 'Elementor Widgets'
        });
        bm.add('custom-accordion', {
            label: 'Accordion / Toggle',
            media: '<i class="fas fa-list"></i>',
            content: `
            <div style="font-family: 'Outfit', sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;">
                <details style="background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); cursor: pointer;">
                    <summary style="font-weight: 600; color: #333; outline: none;">Pertanyaan 1</summary>
                    <p style="color: #666; margin-top: 15px; line-height: 1.6;">Jawaban untuk pertanyaan 1 ada di sini.</p>
                </details>
                <details style="background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); cursor: pointer;">
                    <summary style="font-weight: 600; color: #333; outline: none;">Pertanyaan 2</summary>
                    <p style="color: #666; margin-top: 15px; line-height: 1.6;">Jawaban untuk pertanyaan 2 ada di sini.</p>
                </details>
            </div>
            `,
            category: 'Elementor Widgets',
        });

        // ==========================================
        // KATEGORI: ELEMENTOR TEMPLATES
        // ==========================================
        bm.add('template-hero', {
            label: 'Hero Section',
            media: '<i class="fas fa-window-maximize"></i>',
            content: `
            <div style="background-color: #0D4C54; color: white; padding: 100px 20px; text-align: center; font-family: 'Outfit', sans-serif;">
                <h1 style="font-size: 3rem; margin-bottom: 20px; color: #DCD0C0; font-weight: 800;">Judul Utama Hero</h1>
                <p style="font-size: 1.2rem; max-width: 600px; margin: 0 auto 40px; line-height: 1.6; color: rgba(255,255,255,0.9);">Deskripsi singkat mengenai layanan atau promo unggulan Anda yang menarik perhatian pengunjung.</p>
                <a href="#" style="background-color: #DCD0C0; color: #0D4C54; padding: 15px 35px; text-decoration: none; border-radius: 30px; font-weight: bold; font-size: 1.1rem; display: inline-block;">Amankan Kursi Sekarang</a>
            </div>
            `,
            category: 'Elementor Templates',
        });
        bm.add('template-about', {
            label: 'About Us Section',
            media: '<i class="fas fa-address-card"></i>',
            content: `
            <div style="display: flex; flex-wrap: wrap; gap: 40px; padding: 60px 20px; max-width: 1200px; margin: 0 auto; align-items: center; font-family: 'Outfit', sans-serif;">
                <div style="flex: 1; min-width: 300px;">
                    <img src="https://via.placeholder.com/600x400" style="width: 100%; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                </div>
                <div style="flex: 1; min-width: 300px;">
                    <h4 style="color: #8B5E3C; margin-bottom: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px;">TENTANG KAMI</h4>
                    <h2 style="color: #0D4C54; font-size: 2.5rem; margin-bottom: 20px;">Berpengalaman Melayani Tamu Allah</h2>
                    <p style="color: #666; line-height: 1.8; margin-bottom: 20px;">Elnair Tour & Travel telah dipercaya oleh ribuan jamaah untuk mendampingi perjalanan spiritual mereka.</p>
                    <ul style="list-style: none; padding: 0; color: #333; font-weight: 500;">
                        <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: #0D4C54; margin-right: 10px;"></i> Izin Resmi Kemenag</li>
                        <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: #0D4C54; margin-right: 10px;"></i> Pembimbing Berpengalaman</li>
                    </ul>
                </div>
            </div>
            `,
            category: 'Elementor Templates',
        });
        bm.add('template-features', {
            label: 'Features / Services',
            media: '<i class="fas fa-th-large"></i>',
            content: `
            <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; padding: 40px 20px; font-family: 'Outfit', sans-serif;">
                <div style="flex: 1; min-width: 250px; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
                    <div style="font-size: 40px; color: #8B5E3C; margin-bottom: 20px;"><i class="fas fa-plane"></i></div>
                    <h3 style="color: #0D4C54; margin-bottom: 15px;">Pesawat Terbaik</h3>
                    <p style="color: #666;">Penerbangan langsung tanpa transit yang nyaman.</p>
                </div>
                <div style="flex: 1; min-width: 250px; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
                    <div style="font-size: 40px; color: #8B5E3C; margin-bottom: 20px;"><i class="fas fa-hotel"></i></div>
                    <h3 style="color: #0D4C54; margin-bottom: 15px;">Hotel Bintang 5</h3>
                    <p style="color: #666;">Jarak dekat dengan pelataran Masjid.</p>
                </div>
                <div style="flex: 1; min-width: 250px; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
                    <div style="font-size: 40px; color: #8B5E3C; margin-bottom: 20px;"><i class="fas fa-user-tie"></i></div>
                    <h3 style="color: #0D4C54; margin-bottom: 15px;">Muthawwif Ahli</h3>
                    <p style="color: #666;">Dibimbing oleh asatidz bersertifikat resmi.</p>
                </div>
            </div>
            `,
            category: 'Elementor Templates',
        });
        bm.add('template-testimonial', {
            label: 'Testimonial Block',
            media: '<i class="fas fa-comments"></i>',
            content: `
            <div style="background: #f9f9f9; padding: 60px 20px; text-align: center; font-family: 'Outfit', sans-serif;">
                <h2 style="color: #0D4C54; margin-bottom: 40px;">Apa Kata Jamaah?</h2>
                <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; max-width: 1200px; margin: 0 auto;">
                    <div style="flex: 1; min-width: 300px; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <div style="color: #F59E0B; margin-bottom: 15px; font-size: 1.2rem;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p style="font-style: italic; color: #555; margin-bottom: 20px; line-height: 1.6;">"Layanan yang luar biasa, sangat memuaskan dari awal keberangkatan hingga pulang ke tanah air. Muthawwif sangat sabar."</p>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 15px;">
                            <img src="https://via.placeholder.com/60" style="border-radius: 50%; width: 60px; height: 60px; object-fit: cover;">
                            <div style="text-align: left;">
                                <strong style="color: #0D4C54; display: block;">Bpk. Ahmad</strong>
                                <span style="color: #888; font-size: 0.9rem;">Jamaah Umroh 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `,
            category: 'Elementor Templates'
        });
        bm.add('template-contact', {
            label: 'Contact Block',
            media: '<i class="fas fa-address-book"></i>',
            content: `
            <div style="display: flex; flex-wrap: wrap; gap: 40px; padding: 60px 20px; max-width: 1200px; margin: 0 auto; font-family: 'Outfit', sans-serif;">
                <div style="flex: 1; min-width: 300px;">
                    <h2 style="color: #0D4C54; margin-bottom: 20px;">Hubungi Kami</h2>
                    <p style="color: #666; margin-bottom: 20px;"><i class="fas fa-map-marker-alt" style="color: #8B5E3C; margin-right: 10px;"></i> Jl. Contoh Alamat No. 123, Jakarta</p>
                    <p style="color: #666; margin-bottom: 20px;"><i class="fas fa-phone" style="color: #8B5E3C; margin-right: 10px;"></i> +62 812 3456 7890</p>
                    <p style="color: #666; margin-bottom: 20px;"><i class="fas fa-envelope" style="color: #8B5E3C; margin-right: 10px;"></i> info@elnair.com</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.2400971031!2d106.75874838612984!3d-6.229746499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x100c5e82dd4b820!2sJakarta!5e0!3m2!1sen!2sid!4v1689234856037!5m2!1sen!2sid" width="100%" height="250" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div style="flex: 1; min-width: 300px; background: #f8f9fc; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <h3 style="color: #0D4C54; margin-bottom: 20px;">Tinggalkan Pesan</h3>
                    <form>
                        <input type="text" placeholder="Nama Anda" style="width: 100%; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px;">
                        <input type="email" placeholder="Email Anda" style="width: 100%; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px;">
                        <textarea placeholder="Pesan Anda" rows="4" style="width: 100%; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px;"></textarea>
                        <button type="button" style="width: 100%; padding: 15px; background: #0D4C54; color: #fff; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s;">Kirim Pesan</button>
                    </form>
                </div>
            </div>
            `,
            category: 'Elementor Templates'
        });

        // ==========================================
        // KATEGORI: ELEMENTOR PRO
        // ==========================================
        bm.add('pro-form', {
            label: 'Pro Form',
            media: '<i class="fas fa-wpforms"></i>',
            content: `
            <div style="background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); max-width: 500px; margin: 40px auto; font-family: 'Outfit', sans-serif; border-top: 5px solid #0D4C54;">
                <h3 style="color: #0D4C54; margin-bottom: 25px; text-align: center; font-weight: bold;">Formulir Pendaftaran</h3>
                <form>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: #555; font-weight: 500;">Nama Lengkap</label>
                        <input type="text" placeholder="Masukkan nama sesuai KTP" style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: #555; font-weight: 500;">Nomor WhatsApp</label>
                        <input type="tel" placeholder="0812xxxxxx" style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">
                    </div>
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; margin-bottom: 8px; color: #555; font-weight: 500;">Pilihan Paket</label>
                        <select style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">
                            <option>Paket Umroh Silver</option>
                            <option>Paket Umroh Gold</option>
                            <option>Paket Umroh VIP</option>
                        </select>
                    </div>
                    <button type="button" style="width: 100%; padding: 16px; background: #0D4C54; color: #fff; border: none; border-radius: 8px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: background 0.3s; text-transform: uppercase; letter-spacing: 1px;">Kirim Pendaftaran</button>
                </form>
            </div>
            `,
            category: 'Elementor Pro',
        });
        bm.add('pro-wa', {
            label: 'WhatsApp Checkout',
            media: '<i class="fab fa-whatsapp"></i>',
            content: `
            <div style="text-align: center; padding: 20px;">
                <a href="https://wa.me/628123456789?text=Halo%20saya%20tertarik" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; background-color: #25D366; color: white; padding: 15px 35px; text-decoration: none; border-radius: 50px; font-weight: bold; font-family: 'Outfit', sans-serif; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(37,211,102,0.3); transition: all 0.3s;">
                    <i class="fab fa-whatsapp" style="font-size: 1.8rem;"></i> Pesan via WhatsApp
                </a>
            </div>
            `,
            category: 'Elementor Pro',
        });
        bm.add('pro-pricing', {
            label: 'Pricing Table',
            media: '<i class="fas fa-tags"></i>',
            content: `
            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 40px 30px; text-align: center; font-family: 'Outfit', sans-serif; max-width: 350px; margin: 20px auto; box-shadow: 0 20px 40px rgba(0,0,0,0.08); position: relative; overflow: hidden; background: #fff;">
                <div style="position: absolute; top: 20px; right: -40px; background: #F59E0B; color: #fff; padding: 8px 50px; transform: rotate(45deg); font-size: 0.85rem; font-weight: bold; letter-spacing: 1px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">POPULER</div>
                <h3 style="color: #0D4C54; margin-bottom: 10px; font-size: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Paket Gold</h3>
                <h2 style="color: #8B5E3C; margin-bottom: 25px; font-size: 2.8rem; font-weight: 800;">Rp 30 Juta</h2>
                <ul style="list-style: none; padding: 0; margin-bottom: 35px; color: #555; line-height: 2.2; text-align: left; font-weight: 500;">
                    <li><i class="fas fa-check-circle" style="color: #10B981; margin-right: 12px; font-size: 1.1rem;"></i> Penerbangan Direct Saudia</li>
                    <li><i class="fas fa-check-circle" style="color: #10B981; margin-right: 12px; font-size: 1.1rem;"></i> Hotel Bintang 5 Makkah</li>
                    <li><i class="fas fa-check-circle" style="color: #10B981; margin-right: 12px; font-size: 1.1rem;"></i> Kereta Cepat Haramain</li>
                </ul>
                <a href="#" style="display: block; padding: 15px; background-color: #0D4C54; color: #fff; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 1.1rem; transition: all 0.3s;">Pilih Paket Ini</a>
            </div>
            `,
            category: 'Elementor Pro',
        });
        bm.add('pro-countdown', {
            label: 'Countdown Timer',
            media: '<i class="fas fa-stopwatch"></i>',
            content: { type: 'countdown' },
            category: 'Elementor Pro',
        });
        bm.add('pro-popup', {
            label: 'Popup Builder',
            media: '<i class="fas fa-window-restore"></i>',
            content: `
            <div style="padding: 20px; background: #FEF3C7; color: #92400E; border: 1px dashed #F59E0B; text-align: center; font-family: 'Outfit', sans-serif; border-radius: 8px;">
                <i class="fas fa-bullseye" style="font-size: 1.5rem; display: block; margin-bottom: 10px;"></i>
                <strong>Sistem Popup Aktif.</strong><br/>
                <span style="font-size: 0.9rem;">Trigger popup khusus diatur secara dinamis di background script.</span>
            </div>
            `,
            category: 'Elementor Pro',
        });
        bm.add('pro-animated-headline', {
            label: 'Animated Headline',
            media: '<i class="fas fa-magic"></i>',
            content: `
            <div style="font-family: 'Outfit', sans-serif; text-align: center; padding: 40px 20px;">
                <h2 style="color: #0D4C54; font-size: 3rem; font-weight: 800; line-height: 1.2;">
                    Perjalanan Umroh Yang <br/>
                    <span style="color: #8B5E3C; display: inline-block; position: relative;">
                        Paling Berkesan
                        <svg viewBox="0 0 200 20" style="position: absolute; bottom: -10px; left: 0; width: 100%; height: 20px;">
                            <path d="M 0,10 Q 100,20 200,10" fill="transparent" stroke="#DCD0C0" stroke-width="5" stroke-linecap="round"/>
                        </svg>
                    </span>
                </h2>
            </div>
            `,
            category: 'Elementor Pro',
        });
        bm.add('pro-stats', {
            label: 'Stats Counter',
            media: '<i class="fas fa-chart-line"></i>',
            content: `
            <div style="background-color: #F7F5F2; padding: 60px 20px; display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; font-family: 'Outfit', sans-serif; border-radius: 12px; max-width: 1200px; margin: 40px auto; border: 1px solid #eaeaea;">
                <div style="text-align: center; flex: 1; min-width: 150px;">
                    <h2 style="color: #0D4C54; font-size: 3.5rem; margin-bottom: 10px; font-weight: 800;">5000+</h2>
                    <p style="color: #8B5E3C; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem;">Jamaah Berangkat</p>
                </div>
                <div style="text-align: center; flex: 1; min-width: 150px;">
                    <h2 style="color: #0D4C54; font-size: 3.5rem; margin-bottom: 10px; font-weight: 800;">10</h2>
                    <p style="color: #8B5E3C; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem;">Tahun Pengalaman</p>
                </div>
                <div style="text-align: center; flex: 1; min-width: 150px;">
                    <h2 style="color: #0D4C54; font-size: 3.5rem; margin-bottom: 10px; font-weight: 800;">100%</h2>
                    <p style="color: #8B5E3C; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem;">Indeks Kepuasan</p>
                </div>
            </div>
            `,
            category: 'Elementor Pro',
        });
        bm.add('pro-custom-html', {
            label: 'Custom HTML & Shortcode',
            media: '<i class="fas fa-code"></i>',
            content: { type: 'custom-code' },
            category: 'Elementor Pro',
        });

        // Otomatis buka panel Blocks saat halaman dimuat
        const blocksBtn = pn.getButton('views', 'open-blocks');
        if (blocksBtn) {
            blocksBtn.set('active', 1);
        }

        // TWEAK UX ALA ELEMENTOR: 
        // Otomatis buka tab "Style" (Paint Brush) saat elemen diklik
        editor.on('component:selected', () => {
            const openSmBtn = pn.getButton('views', 'open-sm');
            if (openSmBtn) {
                openSmBtn.set('active', 1);
            }
        });

        // Otomatis kembali ke tab "Blocks" saat klik di luar (tidak ada yang dipilih)
        editor.on('component:deselected', () => {
            if (blocksBtn) {
                blocksBtn.set('active', 1);
            }
        });
    });

    // Fitur Auto-Slug pintar untuk halaman Create
    let slugManuallyEdited = false;
    
    document.querySelector('input[name="slug"]').addEventListener('input', function() {
        slugManuallyEdited = true;
    });

    document.querySelector('input[name="title"]').addEventListener('input', function(e) {
        if (!slugManuallyEdited) {
            let title = e.target.value;
            let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            document.querySelector('input[name="slug"]').value = slug;
        }
    });

    // Fungsi untuk Toggle Layout IDE-Style
    function toggleMode(mode) {
        const leftPanel = document.getElementById('left-form-panel');
        const rightPanel = document.getElementById('right-builder-panel');
        const btnRestoreBuilder = document.getElementById('btn-restore-builder');
        const btnMaxBuilder = document.getElementById('btn-max-builder');
        const btnColBuilder = document.getElementById('btn-col-builder');
        
        const btnMaxForm = document.getElementById('btn-max-form');
        const btnColForm = document.getElementById('btn-col-form');

        if(mode === 'form') {
            leftPanel.style.width = '100%';
            leftPanel.style.borderRight = 'none';
            rightPanel.style.display = 'none';
            
            btnMaxForm.style.display = 'none';
            btnColForm.innerHTML = '<i class="fas fa-compress"></i>';
            btnColForm.setAttribute('onclick', "toggleMode('split')");
            btnColForm.title = 'Restore Form';
        } else if (mode === 'builder') {
            leftPanel.style.width = '0px';
            leftPanel.style.borderRight = 'none';
            rightPanel.style.display = 'flex';
            
            btnRestoreBuilder.style.display = 'block';
            btnMaxBuilder.style.display = 'none';
            btnColBuilder.style.display = 'block';
        } else {
            // NORMAL (SPLIT)
            leftPanel.style.width = '300px';
            leftPanel.style.display = 'flex';
            leftPanel.style.borderRight = '1px solid #ddd';
            rightPanel.style.display = 'flex';
            
            btnMaxForm.style.display = 'block';
            btnColForm.innerHTML = '<i class="fas fa-chevron-left"></i>';
            btnColForm.setAttribute('onclick', "toggleMode('builder')");
            btnColForm.title = 'Collapse Form';
            
            btnRestoreBuilder.style.display = 'none';
            btnMaxBuilder.style.display = 'block';
            btnColBuilder.style.display = 'none';
        }

        // Paksa GrapesJS untuk me-render ulang ukuran canvasnya
        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 350); // tunggu transisi CSS selesai
    }

    // On form submit, extract HTML & CSS
    document.getElementById('landingPageForm').addEventListener('submit', function(e) {
        const html = editor.getHtml();
        const css = editor.getCss();
        const combinedContent = `<style>${css}</style>\n${html}`;
        document.getElementById('content-textarea').value = combinedContent;
    });

    // --- LOGIKA DYNAMIC META PIXEL EVENTS ---
    let eventCounter = 0;
    const standardEvents = ['AddPaymentInfo', 'AddToCart', 'CompleteRegistration', 'Contact', 'InitiateCheckout', 'Lead', 'Purchase', 'Schedule', 'Search', 'SubmitApplication', 'ViewContent', 'Custom'];

    function addPixelEvent(existingData = null) {
        const wrapper = document.getElementById('events-wrapper');
        const eventId = eventCounter++;
        
        let eventName = existingData ? existingData.event_name : '';
        
        let html = `
        <div class="pixel-event-block" id="pixel-event-${eventId}" style="background: #f8f9fc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px; margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <select name="fb_pixel_events[${eventId}][event_name]" class="form-control form-control-sm" style="width: 85%; border: 1px solid #0bbdbd; color: #0D4C54; font-weight: bold;" required>
                    <option value="">Pilih Event...</option>
                    ${standardEvents.map(e => `<option value="${e}" ${eventName === e ? 'selected' : ''}>${e}</option>`).join('')}
                </select>
                <button type="button" onclick="document.getElementById('pixel-event-${eventId}').remove()" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0 5px;" title="Hapus Event"><i class="fas fa-times"></i></button>
            </div>
            
            <div id="params-wrapper-${eventId}" style="margin-left: 10px; border-left: 2px solid #e2e8f0; padding-left: 10px; margin-top: 10px;">
                <label style="font-size: 0.75rem; color: #64748b; margin-bottom: 5px; display: block;">Events Parameter</label>
            </div>
            
            <button type="button" onclick="addParameter(${eventId})" style="background: none; border: none; color: #0bbdbd; font-size: 0.8rem; font-weight: bold; cursor: pointer; margin-top: 8px; padding: 0;">
                + Tambah Parameter
            </button>
        </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);

        // Populate existing params if any
        if (existingData && existingData.params) {
            for (const [keyData] of Object.entries(existingData.params)) {
                addParameter(eventId, existingData.params[keyData].key, existingData.params[keyData].value);
            }
        }
    }

    function addParameter(eventId, key = '', value = '') {
        const paramWrapper = document.getElementById(`params-wrapper-${eventId}`);
        const paramId = Math.random().toString(36).substr(2, 9);
        
        let html = `
        <div id="param-${paramId}" style="display: flex; gap: 5px; margin-bottom: 5px; align-items: center;">
            <input type="text" name="fb_pixel_events[${eventId}][params][${paramId}][key]" value="${key}" placeholder="Key (cth: value)" class="form-control form-control-sm" style="width: 45%; font-size: 0.75rem; padding: 0.25rem 0.5rem;" required>
            <input type="text" name="fb_pixel_events[${eventId}][params][${paramId}][value]" value="${value}" placeholder="Value (cth: 150000)" class="form-control form-control-sm" style="width: 45%; font-size: 0.75rem; padding: 0.25rem 0.5rem;" required>
            <button type="button" onclick="document.getElementById('param-${paramId}').remove()" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 0.8rem; padding: 0 5px;" title="Hapus Parameter"><i class="fas fa-minus-circle"></i></button>
        </div>
        `;
        paramWrapper.insertAdjacentHTML('beforeend', html);
    }
    // ------------------------------------------
</script>
@endsection
