@extends('landing.layouts.app')

@section('content')
<!-- Hero Package Detail -->
<section style="position: relative; height: 60vh; background-image: url('{{ str_starts_with($package->image, 'http') ? $package->image : asset($package->image) }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(13, 76, 84, 0.7);"></div>
    <div class="container" style="position: relative; z-index: 2; text-align: center; color: white;">
        <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Elnair Exclusive Package</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">{{ $package->title }}</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">{{ $package->price_label }} <strong style="font-size: 1.5rem;">{{ $package->price_value }}</strong></p>
    </div>
</section>

<!-- Main Detail Content -->
<section class="pattern-bg" style="padding: 4rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items: start;">
            
            <!-- Left Column: Details -->
            <div class="package-details-content">
                <div class="package-detail-box" style="background: var(--card-bg); padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 class="package-detail-heading" style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Deskripsi Perjalanan</h3>
                    <div class="package-detail-text" style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($package->description)) !!}
                    </div>
                </div>

                @if($package->itinerary)
                <div class="package-detail-box" style="background: var(--card-bg); padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 class="package-detail-heading" style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Itinerary (Jadwal Perjalanan)</h3>
                    <div class="package-detail-text" style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($package->itinerary)) !!}
                    </div>
                </div>
                @endif

                @if($package->fasilitas)
                <div class="package-detail-box" style="background: var(--card-bg); padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 class="package-detail-heading" style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Fasilitas Termasuk</h3>
                    <div class="package-detail-text" style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($package->fasilitas)) !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Sidebar -->
            <div class="package-sidebar" style="position: sticky; top: 100px;">
                <div style="background: var(--brand-dark); color: white; padding: 2rem; border-radius: 20px; box-shadow: 0 15px 40px rgba(13, 76, 84, 0.2);">
                    <h3 style="font-family: 'Playfair Display', serif; margin-bottom: 1.5rem; color: var(--brand-gold);">Akomodasi & Transportasi</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 0.8rem; margin-bottom: 2rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Hotel Makkah</small>
                                <strong>{{ $package->hotel_makkah ?? 'Menyusul' }}</strong>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Hotel Madinah</small>
                                <strong>{{ $package->hotel_madinah ?? 'Menyusul' }}</strong>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-plane"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Maskapai Penerbangan</small>
                                <strong>{{ $package->maskapai ?? 'Menyusul' }}</strong>
                            </div>
                        </div>
                    </div>

                    {{-- Flyer Box & Full Page Viewer --}}
                    @php
                        $flyerUrl = $package->flyer_pdf ? asset($package->flyer_pdf) : asset($package->image);
                        $isFlyerPdf = str_ends_with(strtolower($package->flyer_pdf ?? ''), '.pdf');
                    @endphp
                    <div style="margin-bottom: 1.5rem; background: rgba(255,255,255,0.08); padding: 1.2rem; border-radius: 15px; border: 1px dashed rgba(255,255,255,0.2); text-align: center;">
                        <h4 style="font-size: 0.95rem; color: var(--brand-gold); margin-bottom: 0.8rem;"><i class="fas fa-file-image"></i> Flyer Resmi Paket</h4>
                        @if(!$isFlyerPdf)
                            <div onclick="window.dispatchEvent(new CustomEvent('open-image-modal', { detail: { url: '{{ $flyerUrl }}' } }))" style="cursor: pointer; position: relative; border-radius: 10px; overflow: hidden; max-height: 200px;">
                                <img src="{{ $flyerUrl }}" alt="Flyer {{ $package->title }}" style="width: 100%; height: auto; object-fit: cover;">
                                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem; opacity: 0; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                                    <i class="fas fa-search-plus" style="margin-right: 6px;"></i> Klik Full Page
                                </div>
                            </div>
                        @else
                            <p style="font-size: 0.85rem; opacity: 0.8; margin-bottom: 0.5rem;">Flyer resmi berbentuk file PDF dokumen.</p>
                        @endif
                    </div>

                    {{-- Download Buttons --}}
                    @php
                        $itineraryPdfUrl = $package->itinerary_pdf ? asset($package->itinerary_pdf) : asset('assets/docs/itinerary-haji-umrah.pdf');
                        $flyerPdfUrl = $package->flyer_pdf ? asset($package->flyer_pdf) : asset('assets/docs/flyer-paket-elnair.pdf');
                    @endphp
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <a href="{{ $itineraryPdfUrl }}" download target="_blank" class="btn btn-outline" style="width: 100%; justify-content: center; padding: 0.85rem; font-size: 0.84rem; border-color: rgba(255,255,255,0.4); font-weight: 700;">
                            <i class="fas fa-file-pdf" style="margin-right: 8px; color: #e74c3c;"></i> Download Itinerary (PDF)
                        </a>

                        <a href="{{ $flyerPdfUrl }}" download target="_blank" class="btn btn-outline" style="width: 100%; justify-content: center; padding: 0.85rem; font-size: 0.84rem; border-color: rgba(255,255,255,0.4); font-weight: 700;">
                            <i class="fas fa-file-download" style="margin-right: 8px; color: var(--brand-gold);"></i> Download Flyer Paket (PDF)
                        </a>
                    </div>

                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['wa_number'] ?? '') }}?text=Assalamu'alaikum,%20saya%20ingin%20mendaftar%20paket%20{{ $package->title }}" target="_blank" class="btn btn-gold" style="width: 100%; justify-content: center; padding: 1.2rem;">
                        <i class="fab fa-whatsapp" style="margin-right: 10px;"></i> Daftar Sekarang
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    [data-theme="dark"] .package-detail-box {
        background: var(--card-bg) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
    }

    [data-theme="dark"] .package-detail-heading {
        color: var(--brand-teal) !important;
        border-bottom-color: var(--brand-gold) !important;
    }

    [data-theme="dark"] .package-detail-text {
        color: var(--text-dark) !important;
    }

    @media (max-width: 768px) {
        .package-details-content, .package-sidebar {
            grid-column: span 2;
        }
        .package-sidebar {
            position: static;
            margin-top: 2rem;
        }
    }
</style>
@endsection
