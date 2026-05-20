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
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Deskripsi Perjalanan</h3>
                    <div style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($package->description)) !!}
                    </div>
                </div>

                @if($package->itinerary)
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Itinerary (Jadwal Perjalanan)</h3>
                    <div style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($package->itinerary)) !!}
                    </div>
                </div>
                @endif
                
                @if($package->fasilitas)
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Fasilitas Termasuk</h3>
                    <div style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($package->fasilitas)) !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Sidebar -->
            <div class="package-sidebar" style="position: sticky; top: 100px;">
                <div style="background: var(--brand-dark); color: white; padding: 2rem; border-radius: 20px; box-shadow: 0 15px 40px rgba(13, 76, 84, 0.2);">
                    <h3 style="font-family: 'Playfair Display', serif; margin-bottom: 1.5rem; color: var(--brand-gold);">Akomodasi & Transportasi</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
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

                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['wa_number'] ?? '') }}?text=Assalamu'alaikum,%20saya%20ingin%20mendaftar%20paket%20{{ $package->title }}" target="_blank" class="btn btn-gold" style="width: 100%; justify-content: center; padding: 1.2rem;">
                        <i class="fab fa-whatsapp" style="margin-right: 10px;"></i> Daftar Sekarang
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
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
