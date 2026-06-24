@extends('landing.layouts.app')

@section('content')
<!-- Hero Schedule Detail -->
<section style="position: relative; height: 60vh; background-image: url('{{ $schedule->package && str_starts_with($schedule->package->image, 'http') ? $schedule->package->image : asset($schedule->package->image ?? 'assets/img/hero-premium.webp') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(13, 76, 84, 0.8);"></div>
    <div class="container" style="position: relative; z-index: 2; text-align: center; color: white;">
        <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Jadwal Keberangkatan</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">{{ $schedule->departure_date->translatedFormat('d F Y') }}</h1>
        <h2 style="font-size: 1.5rem; opacity: 0.9; margin-bottom: 1rem;">{{ $schedule->package->title ?? 'Paket Haji/Umroh' }}</h2>
        <p style="font-size: 1.2rem; opacity: 0.9;">{{ $schedule->package->price_label ?? '' }} <strong style="font-size: 1.5rem;">{{ $schedule->package->price_value ?? '' }}</strong></p>
    </div>
</section>

<!-- Main Detail Content -->
<section class="pattern-bg" style="padding: 4rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items: start;">
            
            <!-- Left Column: Details -->
            <div class="package-details-content">
                @if($schedule->package)
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Deskripsi Perjalanan</h3>
                    <div style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($schedule->package->description)) !!}
                    </div>
                </div>

                @if($schedule->package->itinerary)
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Itinerary (Jadwal Perjalanan)</h3>
                    <div style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($schedule->package->itinerary)) !!}
                    </div>
                </div>
                @endif
                
                @if($schedule->package->fasilitas)
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <h3 style="font-family: 'Playfair Display', serif; color: var(--brand-dark); border-bottom: 2px solid var(--brand-gold); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Fasilitas Termasuk</h3>
                    <div style="line-height: 1.8; color: var(--text-dark);">
                        {!! nl2br(e($schedule->package->fasilitas)) !!}
                    </div>
                </div>
                @endif
                @else
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <p>Informasi paket tidak tersedia.</p>
                </div>
                @endif
            </div>

            <!-- Right Column: Sidebar -->
            <div class="package-sidebar" style="position: sticky; top: 100px;">
                <div style="background: var(--brand-dark); color: white; padding: 2rem; border-radius: 20px; box-shadow: 0 15px 40px rgba(13, 76, 84, 0.2);">
                    <h3 style="font-family: 'Playfair Display', serif; margin-bottom: 1.5rem; color: var(--brand-gold);">Info Keberangkatan</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Tanggal</small>
                                <strong>{{ $schedule->departure_date->translatedFormat('d F Y') }}</strong>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Sisa Kursi</small>
                                <strong>{{ $schedule->available_seats }} Seat</strong>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Status</small>
                                @php
                                    $statusColor = $schedule->status == 'Tersedia' ? '#25d366' : ($schedule->status == 'Penuh' ? '#dc3545' : '#ffc107');
                                @endphp
                                <strong style="color: {{ $statusColor }};">{{ $schedule->status }}</strong>
                            </div>
                        </div>
                    </div>

                    @if($schedule->package)
                    <h3 style="font-family: 'Playfair Display', serif; margin-top: 2rem; margin-bottom: 1.5rem; color: var(--brand-gold);">Akomodasi & Transportasi</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Hotel Makkah</small>
                                <strong>{{ $schedule->package->hotel_makkah ?? 'Menyusul' }}</strong>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Hotel Madinah</small>
                                <strong>{{ $schedule->package->hotel_madinah ?? 'Menyusul' }}</strong>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand-gold);">
                                <i class="fas fa-plane"></i>
                            </div>
                            <div>
                                <small style="display: block; opacity: 0.7; font-size: 0.8rem;">Maskapai</small>
                                <strong>{{ $schedule->package->maskapai ?? 'Menyusul' }}</strong>
                            </div>
                        </div>
                    </div>
                    @endif

                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['wa_number'] ?? '') }}?text=Assalamu'alaikum,%20saya%20ingin%20bertanya%20jadwal%20keberangkatan%20{{ $schedule->package->title ?? 'paket' }}%20tanggal%20{{ $schedule->departure_date->translatedFormat('d F Y') }}" target="_blank" class="btn btn-gold" style="width: 100%; justify-content: center; padding: 1.2rem;">
                        <i class="fab fa-whatsapp" style="margin-right: 10px;"></i> Tanya Jadwal Ini
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
