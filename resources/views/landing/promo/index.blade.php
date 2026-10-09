@extends('landing.layouts.app')

@section('content')
<!-- Hero Promo -->
<section class="promo-hero">
    <div class="container">
        <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Penawaran Istimewa</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">Promo & Benefit Elnair</h1>
        <p style="font-size: 1.2rem; opacity: 0.9; max-width: 700px; margin: 0 auto;">Fasilitas eksklusif dan penawaran khusus untuk kenyamanan ibadah Anda dan keluarga.</p>
    </div>
</section>

<!-- Promo Grid -->
<section class="pattern-bg" style="padding: 5rem 0;">
    <div class="container">
        <div class="promo-grid" style="display: grid; gap: 2rem; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));">
            @forelse($promos as $item)
            <div class="promo-card" style="background: var(--card-bg); border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(13,76,84,0.06); border: 1px solid rgba(139,94,60,0.12); display: flex; flex-direction: column; transition: all 0.3s ease;">
                @if($item->image)
                    <div style="position: relative; overflow: hidden; height: 200px;">
                        <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @if($item->badge)
                            <span style="position: absolute; top: 15px; left: 15px; background: rgba(13,76,84,0.9); color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.2);">
                                {{ $item->badge }}
                            </span>
                        @endif
                    </div>
                @endif

                <div style="padding: 1.8rem; display: flex; flex-direction: column; flex: 1;">
                    <h3 class="promo-card-title" style="font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--brand-dark); margin-bottom: 0.8rem; font-weight: 700; line-height: 1.3;">
                        {{ $item->title }}
                    </h3>

                    <p class="promo-card-desc" style="color: var(--text-dark); opacity: 0.8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.2rem;">
                        {{ \Illuminate\Support\Str::limit($item->description, 150) }}
                    </p>

                    @if($item->details)
                        @php
                            $detailsList = is_array(json_decode($item->details, true))
                                ? json_decode($item->details, true)
                                : array_filter(explode("\n", $item->details));
                        @endphp
                        @if(!empty($detailsList))
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.2rem;">
                                @foreach(array_slice($detailsList, 0, 3) as $detail)
                                    <span class="promo-detail-chip" style="background: rgba(139,94,60,0.08); color: var(--brand-gold); padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                        <i class="fas fa-check" style="font-size: 0.7rem; margin-right: 4px;"></i> {{ trim($detail) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    @endif

                    <div style="margin-top: auto;">
                        <a href="{{ route('landing.promo.show', $item->slug) }}" class="btn btn-gold" style="width: 100%; justify-content: center; padding: 0.9rem; font-size: 0.85rem;">
                            Lihat Detail Benefit <i class="fas fa-arrow-right" style="margin-left: 6px; font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem; background: var(--card-bg); border-radius: 20px; border: 1px solid rgba(13, 76, 84, 0.05);">
                <i class="fas fa-gift" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                <h3 style="color: var(--brand-dark); margin-bottom: 0.5rem;">Belum Ada Promo</h3>
                <p style="color: var(--text-dark); opacity: 0.8;">Promo dan penawaran istimewa akan segera hadir di sini.</p>
            </div>
            @endforelse
        </div>

        @if($promos->hasPages())
        <div style="margin-top: 4rem; display: flex; justify-content: center;">
            {{ $promos->links() }}
        </div>
        @endif
    </div>
</section>

<style>
    .promo-hero {
        position: relative;
        padding: 150px 0 80px 0;
        background: #0D4C54;
        color: white;
        text-align: center;
    }

    [data-theme="dark"] .promo-hero {
        background: #0C1517;
        border-bottom: 1px solid rgba(123, 191, 200, 0.1);
    }

    .promo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(13,76,84,0.12) !important;
        border-color: var(--brand-gold) !important;
    }

    [data-theme="dark"] .promo-card {
        background: var(--card-bg) !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
    }

    [data-theme="dark"] .promo-card-title {
        color: var(--brand-teal) !important;
    }

    [data-theme="dark"] .promo-card-desc {
        color: var(--text-dark) !important;
        opacity: 0.75 !important;
    }

    [data-theme="dark"] .promo-detail-chip {
        background: rgba(102, 165, 173, 0.15) !important;
        color: var(--brand-teal) !important;
    }

    @media (max-width: 640px) {
        .promo-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
