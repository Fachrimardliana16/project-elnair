{{-- 
    Packages Section — Responsive Multi-Device Grid
    Mobile Portrait (<640px)  : 1 column, tap-target compliant CTA buttons (min-height 48px)
    Tablet (md: 768px-1024px)  : 2 columns
    Desktop (lg: 1024px+)      : 3 columns
    
    All images: aspect-ratio locked to prevent CLS. Overlay scrim for WCAG contrast.
--}}

<!-- Packages Elite -->
<section id="paket" class="pattern-bg" style="height: auto !important; min-height: 100vh !important; padding: 6rem 0 !important; overflow: visible !important; display: flex; flex-direction: column; justify-content: center; position: relative;">
    <div class="container">
        <div class="section-header reveal">
            <span style="letter-spacing: 8px;">Paket Haji &amp; Umroh</span>
            <h2 style="font-size: clamp(2rem, 6vw, 3.5rem);">Pilih Paket, Mulai Perjalanan Suci Anda</h2>
            <div style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(231,76,60,0.1); border:1px solid rgba(231,76,60,0.3); border-radius:50px; padding:0.4rem 1rem; margin-top:0.75rem;">
                <div style="width:8px;height:8px;background:#e74c3c;border-radius:50%;display:inline-block;flex-shrink:0;position:relative;"><div style="position:absolute;inset:0;border-radius:50%;background:#e74c3c;animation:onlinePulse 1.8s ease-in-out infinite;will-change:transform,opacity;"></div></div>
                <div style="font-size:0.75rem;color:#e74c3c;font-weight:700;margin:0;letter-spacing:0;text-transform:uppercase;">KUOTA TERBATAS — HARGA BERUBAH SEWAKTU-WAKTU</div>
            </div>
        </div>

        {{-- Responsive grid: 1 col mobile → 2 col tablet → 3 col desktop --}}
        <div class="pkg-grid-responsive">
            @foreach($packages as $index => $pkg)
            @php
                $isExtra = $index >= 3;
            @endphp
            <div class="pkg-card reveal {{ $isExtra ? 'pkg-card-extra' : '' }}" style="{{ $isExtra ? 'display: none; opacity: 0; transform: translateY(24px);' : '' }}">
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

        @if($packages->count() > 3)
        <div style="text-align: center; margin-top: 4rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;" class="reveal">
            <button id="btn_toggle_packages" class="btn btn-outline" style="border: 2px solid var(--brand-gold); color: var(--brand-gold); background: transparent; padding: 1rem 2.8rem; border-radius: 50px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 0.8rem; cursor: pointer; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; gap: 10px;">
                <span id="btn_toggle_text">Lihat Selanjutnya</span> 
                <i id="btn_toggle_icon" class="fas fa-chevron-down"></i>
            </button>
            <a href="{{ route('paket.index') }}" class="btn btn-gold" style="padding: 1rem 2.8rem; border-radius: 50px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 0.8rem; display: inline-flex; align-items: center; justify-content: center; transition: 0.3s; background: var(--brand-gold); color: white; border: 2px solid var(--brand-gold);">
                Lihat Selengkapnya
            </a>
        </div>
        @else
        <div style="text-align: center; margin-top: 4rem;" class="reveal">
            <a href="{{ route('paket.index') }}" class="btn btn-gold" style="padding: 1rem 2.8rem; border-radius: 50px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 0.8rem; display: inline-flex; align-items: center; justify-content: center; transition: 0.3s; background: var(--brand-gold); color: white; border: 2px solid var(--brand-gold);">
                Lihat Selengkapnya
            </a>
        </div>
        @endif
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

.pkg-card-extra {
    transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btn_toggle_packages');
    if (!btn) return;
    
    const extraCards = document.querySelectorAll('.pkg-card-extra');
    const textSpan = document.getElementById('btn_toggle_text');
    const icon = document.getElementById('btn_toggle_icon');
    let isExpanded = false;
    
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        isExpanded = !isExpanded;
        
        if (isExpanded) {
            extraCards.forEach(card => {
                // Set display flex first
                card.style.display = 'flex';
                // Trigger transition in next animation frame
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    });
                });
            });
            textSpan.textContent = 'Lihat Lebih Sedikit';
            icon.className = 'fas fa-chevron-up';
        } else {
            extraCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(24px)';
                // Hide after transition completes
                setTimeout(() => {
                    if (!isExpanded) {
                        card.style.display = 'none';
                    }
                }, 500);
            });
            textSpan.textContent = 'Lihat Selanjutnya';
            icon.className = 'fas fa-chevron-down';
            
            // Scroll back to packages section smoothly
            document.getElementById('paket').scrollIntoView({ behavior: 'smooth' });
        }
    });
});
</script>
