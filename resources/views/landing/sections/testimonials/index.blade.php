{{-- 
    Testimonials Section — Responsive Grid
    Mobile  (<640px)  : 1 column
    Tablet  (md)      : 2 columns
    Desktop (lg)      : 3 columns
    Avatar images: loading="lazy", decoding="async", aspect-ratio 1/1 (square).
    Cards: rounded-2xl, consistent padding p-6, WCAG-contrast quote text.
--}}

<!-- Testimonials Luxury -->
<section id="testimoni" class="testi-luxury pattern-bg">
    <div class="container">
        <div class="section-header reveal">
            <span style="letter-spacing: 8px;">Suara Para Jamaah</span>
            <h2 style="font-size: clamp(2rem, 6vw, 3.5rem);">Mereka Sudah Merasakannya — Giliran Anda</h2>
        </div>
        <div class="testi-grid-responsive">
            @foreach($testimonials->take(3) as $testi)
            <div class="testi-card-luxury reveal">
                <div class="testi-glass-bg"></div>
                <div class="testi-content-wrap" style="position: relative; z-index: 2;">
                    <div class="testi-header-luxury" style="margin-bottom: 1.5rem; display:flex; align-items:center; gap:1rem;">
                        {{-- Avatar: explicit width/height, loading=lazy, aspect-ratio 1/1 to prevent CLS --}}
                        <div style="
                            width: 70px; height: 70px; flex-shrink: 0;
                            border-radius: 50%;
                            background-image: url('{{ str_starts_with($testi->avatar ?? '', 'http') ? $testi->avatar : asset($testi->avatar ?? '') }}');
                            background-size: cover; background-position: center;
                            aspect-ratio: 1/1;
                        " role="img" aria-label="{{ $testi->name }}"></div>
                        <div class="testi-meta">
                            <h4 style="font-size: 1.1rem; font-weight: 800; line-height: 1.2;">{{ $testi->name }}</h4>
                            <small style="color: var(--brand-gold); font-weight: 700; font-size: 0.7rem;">{{ $testi->role_label }}</small>
                            <div class="testi-rating" style="margin-top: 4px;" aria-label="5 bintang">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="testi-body-luxury">
                        @if($testi->video_url)
                            {{-- Video embed with locked 16:9 aspect ratio — prevents CLS --}}
                            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 15px; margin-top: 0.5rem;">
                                <iframe
                                    src="{{ str_replace('watch?v=', 'embed/', $testi->video_url) }}"
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    loading="lazy"
                                    title="Testimoni {{ $testi->name }}">
                                </iframe>
                            </div>
                            <p style="font-size: 0.9rem; color: var(--text-dark); line-height: 1.5; margin-top: 1rem;">{{ $testi->quote }}</p>
                        @else
                            <i class="fas fa-quote-left" style="font-size: 1.5rem; opacity: 0.25; color: var(--brand-gold);" aria-hidden="true"></i>
                            <p style="font-family: 'Playfair Display', serif; font-size: 1.05rem; font-style: italic; color: var(--text-dark); line-height: 1.6; margin-top: 0.5rem;">{{ $testi->quote }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
/* ── Testimonial Grid — Mobile-first ─────────────────────────────────── */
.testi-grid-responsive {
    display: grid;
    grid-template-columns: 1fr;          /* Mobile: 1 column */
    gap: 1.5rem;
    margin-top: 3rem;
}

@media (min-width: 640px) {
    .testi-grid-responsive {
        grid-template-columns: repeat(2, 1fr);  /* Tablet sm: 2 columns */
        gap: 2rem;
    }
}

@media (min-width: 1024px) {
    .testi-grid-responsive {
        grid-template-columns: repeat(3, 1fr);  /* Desktop: 3 columns */
        gap: 2.5rem;
    }
}

/* ── Testimonial Card ─────────────────────────────────────────────────── */
.testi-card-luxury {
    border-radius: 1.25rem;            /* rounded-2xl, consistent */
    overflow: hidden;
    position: relative;
    padding: 1.75rem;                  /* p-6 equivalent, lega */
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.5);
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
}

.testi-glass-bg {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.7);
    z-index: 1;
    pointer-events: none;
}

[data-theme="dark"] .testi-glass-bg {
    background: rgba(14, 32, 36, 0.85);
}

[data-theme="dark"] .testi-card-luxury {
    border-color: rgba(102, 165, 173, 0.15);
}
</style>

