@extends('landing.layouts.app')

@section('content')
<div style="background: linear-gradient(180deg, var(--brand-dark) 0%, #082D32 100%); padding: 120px 0 60px; color: white; text-align: center;">
    <div class="container">
        @if($promo->badge)
            <span style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: var(--brand-gold); padding: 6px 20px; border-radius: 50px; font-weight: 800; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; display: inline-block; margin-bottom: 1rem; border: 1px solid rgba(255,255,255,0.2);">
                {{ $promo->badge }}
            </span>
        @endif
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3.5rem); font-weight: 900; margin-bottom: 1rem; color: white;">
            {{ $promo->title }}
        </h1>
        <p style="font-size: 1.1rem; opacity: 0.9; max-width: 700px; margin: 0 auto;">
            Solusi perjalanan ibadah nyaman, aman, dan berkesan dengan fasilitas eksklusif untuk Anda dan keluarga.
        </p>
    </div>
</div>

<section style="padding: 5rem 0; background: var(--bg-silk);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start;">
            <!-- Left: Visual Image -->
            <div>
                @if($promo->image)
                    <div style="border-radius: 30px; overflow: hidden; box-shadow: 0 25px 60px rgba(13,76,84,0.18); border: 2px solid rgba(139,94,60,0.15); position: relative;">
                        <img src="{{ asset($promo->image) }}" alt="{{ $promo->title }}" style="width: 100%; height: auto; display: block; object-fit: cover;">
                    </div>
                @else
                    <div style="height: 400px; background: rgba(13,76,84,0.05); border-radius: 30px; display: flex; align-items: center; justify-content: center; color: var(--brand-dark); font-size: 3rem;">
                        <i class="fas fa-gift"></i>
                    </div>
                @endif
            </div>

            <!-- Right: Details & Benefits -->
            <div>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--brand-dark); font-weight: 800; margin-bottom: 1.2rem;" class="promo-show-title">
                    Tentang Penawaran Ini
                </h2>

                <p style="color: var(--text-dark); opacity: 0.85; font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem;">
                    {{ $promo->description }}
                </p>

                @if($promo->details)
                    @php
                        $detailsList = is_array(json_decode($promo->details, true)) 
                            ? json_decode($promo->details, true) 
                            : array_filter(explode("\n", $promo->details));
                    @endphp
                    @if(!empty($detailsList))
                        <div class="promo-details-card" style="background: var(--card-bg); border-radius: 20px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(139,94,60,0.1); margin-bottom: 2.5rem;">
                            <h3 style="font-size: 1.15rem; color: var(--brand-dark); font-weight: 700; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.5rem;" class="promo-details-subtitle">
                                <i class="fas fa-cubes" style="color: var(--brand-gold);"></i> Benefit & Fasilitas yang Didapatkan:
                            </h3>
                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.8rem;">
                                @foreach($detailsList as $detail)
                                    <li style="display: flex; align-items: flex-start; gap: 0.85rem; font-size: 0.95rem; color: var(--text-dark); line-height: 1.5;">
                                        <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--brand-dark); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; flex-shrink: 0; margin-top: 2px;">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <span>{{ trim($detail) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif

                <!-- CTA Buttons & PDF Download -->
                @php
                    $promoPdfUrl = $promo->pdf_file ? asset($promo->pdf_file) : asset('assets/docs/flyer-paket-elnair.pdf');
                @endphp
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="#" class="btn btn-gold btn-wa-rotator" data-wa-text="Halo Elnair Travel, saya tertarik dengan promo: {{ $promo->title }}. Mohon info selengkapnya." style="padding: 1.1rem 2.5rem; font-size: 0.9rem;">
                        <i class="fab fa-whatsapp" style="font-size: 1.2rem; margin-right: 8px;"></i> Klaim Benefit via WhatsApp
                    </a>
                    
                    <a href="{{ $promoPdfUrl }}" download target="_blank" class="btn btn-outline promo-btn-outline" style="color: var(--brand-dark); border-color: var(--brand-dark); padding: 1.1rem 2rem; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf" style="color: #e74c3c; font-size: 1.1rem;"></i> Download PDF Brosur Benefit
                    </a>

                    <a href="{{ url('/') }}#paket" class="btn btn-outline promo-btn-outline" style="color: var(--brand-dark); border-color: var(--brand-dark); padding: 1.1rem 2rem;">
                        Lihat Paket Layanan
                    </a>
                </div>
            </div>
        </div>

        @if(isset($otherPromos) && $otherPromos->count() > 0)
            <div style="margin-top: 6rem; padding-top: 4rem; border-top: 1px solid rgba(0,0,0,0.08);" class="promo-other-divider">
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--brand-dark); font-weight: 800; margin-bottom: 2rem; text-align: center;" class="promo-other-title">
                    Benefit Lainnya
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    @foreach($otherPromos as $item)
                        <div class="promo-card-compact" style="background: var(--card-bg); border-radius: 20px; padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid rgba(139,94,60,0.12); display: flex; flex-direction: column;">
                            <h4 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--brand-dark); margin-bottom: 0.5rem; font-weight: 700;">
                                {{ $item->title }}
                            </h4>
                            <p style="color: var(--text-dark); opacity: 0.8; font-size: 0.88rem; line-height: 1.5; margin-bottom: 1.2rem;">
                                {{ \Illuminate\Support\Str::limit($item->description, 100) }}
                            </p>
                            <a href="{{ route('landing.promo.show', $item->slug) }}" style="color: var(--brand-gold); font-weight: 700; text-decoration: none; font-size: 0.85rem; margin-top: auto; display: flex; align-items: center; gap: 0.4rem;">
                                <span>Lihat Benefit Ini</span> <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<style>
[data-theme="dark"] .promo-show-title,
[data-theme="dark"] .promo-details-subtitle,
[data-theme="dark"] .promo-other-title {
    color: var(--text-dark) !important;
}

[data-theme="dark"] .promo-details-card {
    background: var(--card-bg) !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
}

[data-theme="dark"] .promo-other-divider {
    border-top-color: rgba(255, 255, 255, 0.1) !important;
}

[data-theme="dark"] .promo-btn-outline {
    color: var(--brand-teal) !important;
    border-color: var(--brand-teal) !important;
}
</style>
@endsection
