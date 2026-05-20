{{-- 
    Packages Section — Responsive Multi-Device Grid
    Mobile Portrait (<640px)  : 1 column, tap-target compliant CTA buttons (min-height 48px)
    Tablet (md: 768px-1024px)  : 2 columns
    Desktop (lg: 1024px+)      : 3 columns
    
    All images: aspect-ratio locked to prevent CLS. Overlay scrim for WCAG contrast.
--}}

<!-- Packages Elite -->
<section id="paket" class="pattern-bg">
    <div class="container">
        <div class="section-header reveal">
            <span style="letter-spacing: 8px;">Curated Journeys</span>
            <h2 style="font-size: clamp(2rem, 6vw, 3.5rem);">Paket Ibadah Pilihan</h2>
        </div>

        {{-- Responsive grid: 1 col mobile → 2 col tablet → 3 col desktop --}}
        <div class="pkg-grid-responsive">
            @foreach($packages->take(3) as $pkg)
            <div class="pkg-card reveal">
                {{-- Image box with locked 4:3 aspect ratio to prevent Cumulative Layout Shift --}}
                <div class="pkg-img-box" style="position: relative; overflow: hidden; aspect-ratio: 4/3;">
                    <div class="pkg-img" style="
                        background-image: url('{{ str_starts_with($pkg->image ?? '', 'http') ? $pkg->image : asset($pkg->image ?? '') }}');
                        background-size: cover;
                        background-position: center;
                        position: absolute; inset: 0;
                    "></div>
                    {{-- Gradient scrim for WCAG text contrast compliance --}}
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.55) 0%,transparent 60%);pointer-events:none;"></div>
                    <div class="pkg-price-tag" style="
                        position: absolute; bottom: 1rem; left: 1rem;
                        background: var(--brand-dark); color: white;
                        padding: 0.3rem 0.8rem; border-radius: 6px;
                        font-size: 0.8rem; font-weight: 700;
                    ">{{ $pkg->price_label }} {{ $pkg->price_value }}</div>
                </div>

                <div class="pkg-content" style="padding: 1.5rem 1.5rem 1.25rem; background: var(--card-bg);">
                    <h3 style="font-size: clamp(1.1rem, 2.5vw, 1.5rem); margin-bottom: 0.65rem; line-height: 1.3;">{{ $pkg->title }}</h3>
                    <p style="font-size: 0.9rem; line-height: 1.6; opacity: 0.8; max-width: 42ch;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($pkg->description), 120) }}
                    </p>

                    {{-- CTA buttons: full-width stacked on mobile, side-by-side on sm+ --}}
                    <div class="pkg-cta-row">
                        <a href="{{ route('paket.show', $pkg->slug) }}" class="btn btn-outline pkg-btn">Lihat Detail</a>
                        <a href="#"
                           class="btn btn-gold pkg-btn btn-wa-rotator"
                           data-wa-text="Halo Elnair, saya tertarik dengan paket {{ $pkg->title }}"
                           aria-label="Pesan paket {{ $pkg->title }} via WhatsApp">
                            Pesan
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 4rem;" class="reveal">
            <a href="#" style="color: var(--brand-gold); text-decoration: none; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 0.8rem;">
                Lihat Semua Paket Eksklusif <i class="fas fa-chevron-right" style="margin-left: 10px;"></i>
            </a>
        </div>
    </div>
</section>

<style>
/* ── Package Grid — Mobile-first Responsive Breakpoints ──────────────── */
.pkg-grid-responsive {
    display: grid;
    grid-template-columns: 1fr;       /* Mobile portrait: single column */
    gap: 1.5rem;
    margin-top: 3rem;
}

@media (min-width: 640px) {
    .pkg-grid-responsive {
        grid-template-columns: repeat(2, 1fr); /* Tablet sm: 2 columns */
        gap: 2rem;
    }
}

@media (min-width: 1024px) {
    .pkg-grid-responsive {
        grid-template-columns: repeat(3, 1fr); /* Desktop: 3 columns */
    }
}

/* ── Package Card ─────────────────────────────────────────────────────── */
.pkg-card {
    border-radius: 1.25rem;       /* rounded-2xl — consistent across all cards */
    overflow: hidden;
    background: var(--card-bg, #fff);
    box-shadow: 0 8px 30px rgba(0,0,0,0.07);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    display: flex;
    flex-direction: column;
}

.pkg-card:hover {
    box-shadow: 0 20px 50px rgba(0,0,0,0.13);
    transform: translateY(-4px);
}

.pkg-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* ── CTA Row inside card ─────────────────────────────────────────────── */
.pkg-cta-row {
    display: flex;
    flex-direction: column;        /* Mobile: stacked full-width */
    gap: 0.75rem;
    margin-top: auto;
    padding-top: 1.25rem;
}

@media (min-width: 480px) {
    .pkg-cta-row {
        flex-direction: row;       /* 480px+: side-by-side */
        flex-wrap: wrap;
    }
}

/* ── Package CTA Buttons — WCAG tap-target compliant (min 48px height) ─ */
.pkg-btn {
    flex: 1;
    justify-content: center;
    text-align: center;
    border-radius: 10px;
    min-height: 48px;              /* iOS/Android tap target standard */
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    font-weight: 700;
    transition: transform 0.15s ease, background 0.2s ease;
}

.pkg-btn:hover  { transform: scale(1.02); }
.pkg-btn:active { transform: scale(0.98); }

.pkg-card .btn-outline.pkg-btn {
    border-color: var(--brand-dark);
    color: var(--brand-dark);
}
</style>

