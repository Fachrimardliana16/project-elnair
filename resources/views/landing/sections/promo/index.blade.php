<!-- Section Promo & Alur Kerja (Ultra-Compact Single Frame Layout) -->
<section id="promo" class="pattern-bg" style="padding: 3.5rem 0 !important; height: auto !important; min-height: auto !important; background: var(--bg-silk);">
    <div class="container">
        <!-- Section Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <span style="color: var(--brand-gold); text-transform: uppercase; letter-spacing: 3px; font-weight: 800; font-size: 0.75rem; display: block; margin-bottom: 0.5rem;">
                <i class="fas fa-gift" style="margin-right: 4px;"></i> Benefit
            </span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 2.5rem); color: var(--brand-dark); font-weight: 800; margin: 0 0 1rem 0;" class="promo-header-title">
                Penawaran Jamaah Wanita & Keluarga
            </h2>
            <p style="max-width: 650px; margin: 0 auto; color: var(--text-dark); opacity: 0.8; font-size: 0.95rem; line-height: 1.6;" class="promo-header-subtext">
                Fasilitas personal kit lengkap & pendampingan ramah jamaah wanita untuk kenyamanan ibadah Anda.
            </p>
        </div>

        @if(isset($promos) && $promos->count() > 0)
            @if($promos->count() === 1)
                {{-- Featured Single Promo Layout --}}
                @php $item = $promos->first(); @endphp
                <div class="promo-featured" style="background: var(--card-bg); border-radius: 24px; overflow: hidden; box-shadow: 0 12px 40px rgba(13,76,84,0.1); border: 1px solid rgba(139,94,60,0.15); display: grid; grid-template-columns: 1fr 1fr; gap: 0; margin-bottom: 1.5rem; align-items: center;">
                    @if($item->image)
                        <div style="position: relative; overflow: hidden; height: 400px;">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @if($item->badge)
                                <span style="position: absolute; top: 20px; left: 20px; background: rgba(13,76,84,0.95); color: #fff; padding: 8px 16px; border-radius: 25px; font-size: 0.8rem; font-weight: 700; border: 2px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px);">
                                    {{ $item->badge }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <div style="padding: 3rem 3.5rem;">
                        <h3 class="promo-featured-title" style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--brand-dark); margin-bottom: 1rem; font-weight: 800; line-height: 1.2;">
                            {{ $item->title }}
                        </h3>

                        <p class="promo-featured-desc" style="color: var(--text-dark); opacity: 0.85; font-size: 1rem; line-height: 1.7; margin-bottom: 1.5rem;">
                            {{ $item->description }}
                        </p>

                        @if($item->details)
                            @php
                                $detailsList = is_array(json_decode($item->details, true))
                                    ? json_decode($item->details, true)
                                    : array_filter(explode("\n", $item->details));
                            @endphp
                            @if(!empty($detailsList))
                                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 2rem;">
                                    @foreach(array_slice($detailsList, 0, 4) as $detail)
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--brand-gold); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; flex-shrink: 0;">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <span class="promo-featured-detail" style="color: var(--text-dark); font-size: 0.9rem; font-weight: 500;">
                                                {{ trim($detail) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif

                        <a href="{{ route('landing.promo.show', $item->slug) }}" class="btn btn-gold" style="padding: 1rem 2.5rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px;">
                            Lihat Detail Benefit <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @elseif($promos->count() === 2)
                {{-- Two Promos: Side-by-Side Fixed Width --}}
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-bottom: 1.5rem; max-width: 900px; margin-left: auto; margin-right: auto;">
                    @foreach($promos as $item)
                        <div class="promo-card-vertical" style="background: var(--card-bg); border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(13,76,84,0.06); border: 1px solid rgba(139,94,60,0.12); display: flex; flex-direction: column; transition: all 0.3s ease;">
                            @if($item->image)
                                <div style="position: relative; overflow: hidden; height: 220px;">
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @if($item->badge)
                                        <span style="position: absolute; top: 15px; left: 15px; background: rgba(13,76,84,0.9); color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.2);">
                                            {{ $item->badge }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div style="padding: 1.8rem; display: flex; flex-direction: column; flex: 1;">
                                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.3rem; color: var(--brand-dark); margin-bottom: 0.8rem; font-weight: 700; line-height: 1.3;">
                                    {{ $item->title }}
                                </h3>

                                <p style="color: var(--text-dark); opacity: 0.8; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.2rem;">
                                    {{ \Illuminate\Support\Str::limit($item->description, 120) }}
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

                                <a href="{{ route('landing.promo.show', $item->slug) }}" style="color: var(--brand-gold); font-weight: 700; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-top: auto;">
                                    <span>Lihat Detail Benefit</span>
                                    <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Compact Grid Layout for Multiple Promos (3+) --}}
                <div class="promo-grid-compact" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                    @foreach($promos as $item)
                    <div class="promo-card-compact" style="background: var(--card-bg); border-radius: 18px; overflow: hidden; box-shadow: 0 8px 25px rgba(13,76,84,0.06); border: 1px solid rgba(139,94,60,0.12); display: flex; flex-direction: row; align-items: stretch; transition: all 0.3s ease;">
                        @if($item->image)
                            <div style="width: 140px; min-width: 140px; position: relative; overflow: hidden;">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @if($item->badge)
                                    <span style="position: absolute; top: 10px; left: 10px; background: rgba(13,76,84,0.9); color: #fff; padding: 3px 8px; border-radius: 20px; font-size: 0.65rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.2);">
                                        {{ $item->badge }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <div style="padding: 1.2rem 1.4rem; display: flex; flex-direction: column; flex: 1;">
                            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.15rem; color: var(--brand-dark); margin-bottom: 0.4rem; font-weight: 700; line-height: 1.3;">
                                {{ $item->title }}
                            </h3>

                            <p style="color: var(--text-dark); opacity: 0.8; font-size: 0.82rem; line-height: 1.45; margin-bottom: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $item->description }}
                            </p>

                            @if($item->details)
                                @php
                                    $detailsList = is_array(json_decode($item->details, true)) 
                                        ? json_decode($item->details, true) 
                                        : array_filter(explode("\n", $item->details));
                                @endphp
                                @if(!empty($detailsList))
                                    <div style="display: flex; gap: 0.4rem; flex-wrap: wrap; margin-bottom: 0.8rem;">
                                        @foreach(array_slice($detailsList, 0, 3) as $detail)
                                            <span class="promo-detail-chip" style="background: rgba(139,94,60,0.08); color: var(--brand-gold); padding: 2px 8px; border-radius: 12px; font-size: 0.72rem; font-weight: 600;">
                                                <i class="fas fa-check" style="font-size: 0.65rem; margin-right: 3px;"></i> {{ trim($detail) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            @endif

                            <div style="margin-top: auto;">
                                <a href="{{ route('landing.promo.show', $item->slug) }}" style="color: var(--brand-gold); font-weight: 700; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <span>Lihat Detail Benefit</span>
                                    <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

            {{-- Button Lihat Semua Promo --}}
            @if($promos->count() > 0)
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="{{ route('landing.promo.index') }}" class="btn btn-gold" style="padding: 0.9rem 2rem; font-size: 0.9rem;">
                        Lihat Detail Benefit <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                    </a>
                </div>
            @endif
        @endif

        {{-- Section Alur Kerja / Workflow (Compact Horizontal Row inside same frame) --}}
        @include('landing.sections.workflow.index')
    </div>
</section>

<style>
.promo-card-compact:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(13,76,84,0.12) !important;
    border-color: var(--brand-gold) !important;
}

.promo-card-vertical:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(13,76,84,0.12) !important;
    border-color: var(--brand-gold) !important;
}

.promo-featured:hover {
    box-shadow: 0 20px 50px rgba(13,76,84,0.15) !important;
}

[data-theme="dark"] #promo {
    background: var(--bg-silk) !important;
}

[data-theme="dark"] .promo-header-title {
    color: var(--text-dark) !important;
}

[data-theme="dark"] .promo-header-subtext {
    color: var(--text-dark) !important;
    opacity: 0.8 !important;
}

[data-theme="dark"] .promo-featured {
    background: var(--card-bg) !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3) !important;
}

[data-theme="dark"] .promo-featured-title {
    color: var(--brand-teal) !important;
}

[data-theme="dark"] .promo-featured-desc,
[data-theme="dark"] .promo-featured-detail {
    color: var(--text-dark) !important;
}

[data-theme="dark"] .promo-card-vertical {
    background: var(--card-bg) !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
}

[data-theme="dark"] .promo-card-vertical h3 {
    color: var(--brand-teal) !important;
}

[data-theme="dark"] .promo-card-vertical p {
    color: var(--text-dark) !important;
    opacity: 0.75 !important;
}

[data-theme="dark"] .promo-card-compact {
    background: var(--card-bg) !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
}

[data-theme="dark"] .promo-card-compact h3 {
    color: var(--brand-teal) !important;
}

[data-theme="dark"] .promo-card-compact p {
    color: var(--text-dark) !important;
    opacity: 0.75 !important;
}

[data-theme="dark"] .promo-detail-chip {
    background: rgba(102, 165, 173, 0.15) !important;
    color: var(--brand-teal) !important;
}

@media (max-width: 768px) {
    .promo-featured {
        grid-template-columns: 1fr !important;
    }
    .promo-featured > div:first-child {
        height: 250px !important;
    }
    .promo-featured > div:last-child {
        padding: 2rem 1.5rem !important;
    }
}

@media (max-width: 640px) {
    .promo-card-compact {
        flex-direction: column !important;
    }
    .promo-card-compact > div:first-child {
        width: 100% !important;
        height: 160px !important;
    }

    /* 2 promo layout jadi 1 kolom di mobile */
    .promo-card-vertical {
        grid-column: span 2 !important;
    }
}
</style>
