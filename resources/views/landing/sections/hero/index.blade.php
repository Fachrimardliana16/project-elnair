{{-- 
    Hero Section — Mobile-first Responsive
    - h1 font-size: clamp() to prevent overflow on mobile portrait
    - .hero-btns: flex-col on mobile, flex-row on sm+
    - Buttons: min-height 48px (tap target), w-full on mobile
    - Hero background: eager loading (LCP element), explicit height with aspect-ratio
--}}

<!-- Luxury Hero -->
<header class="hero" id="home">
    {{-- 
        Hero background: <picture> element (NOT CSS background-image).
        Reason: CSS background-image is NOT scanned by the browser's preload scanner.
        An <img> inside <picture> IS scanned immediately at HTML parse time.
        fetchpriority="high" + loading="eager" = browser prioritizes this above all else.
        Mobile gets a 40KB image; desktop gets 88KB — major LCP improvement on mobile.
    --}}
    <div class="hero-slideshow">
        <picture class="hero-bg-picture slide active" aria-hidden="true">
            <source media="(max-width: 768px)" srcset="{{ ($hero && $hero->background_image) ? asset($hero->background_image) : asset('assets/img/hero-premium-mobile.webp') }}">
            <img src="{{ ($hero && $hero->background_image) ? asset($hero->background_image) : asset('assets/img/hero-premium.webp') }}" alt="" class="hero-bg-img" fetchpriority="high" loading="eager" decoding="async" width="1024" height="1024">
        </picture>
        <picture class="hero-bg-picture slide" aria-hidden="true">
            <source media="(max-width: 768px)" srcset="{{ ($hero && $hero->background_image_2) ? asset($hero->background_image_2) : (($hero && $hero->background_image) ? asset($hero->background_image) : asset('assets/img/hero-premium-mobile.webp')) }}">
            <img src="{{ ($hero && $hero->background_image_2) ? asset($hero->background_image_2) : (($hero && $hero->background_image) ? asset($hero->background_image) : asset('assets/img/hero-premium.webp')) }}" alt="" class="hero-bg-img" loading="lazy" decoding="async" width="1024" height="1024">
        </picture>
        <picture class="hero-bg-picture slide" aria-hidden="true">
            <source media="(max-width: 768px)" srcset="{{ ($hero && $hero->background_image_3) ? asset($hero->background_image_3) : (($hero && $hero->background_image) ? asset($hero->background_image) : asset('assets/img/hero-premium-mobile.webp')) }}">
            <img src="{{ ($hero && $hero->background_image_3) ? asset($hero->background_image_3) : (($hero && $hero->background_image) ? asset($hero->background_image) : asset('assets/img/hero-premium.webp')) }}" alt="" class="hero-bg-img" loading="lazy" decoding="async" width="1024" height="1024">
        </picture>
    </div>
    <div class="container">
        <div class="hero-content reveal active">
            <div class="hero-badge">
                <i class="fas fa-person-praying" aria-hidden="true"></i>
                <span>{{ $hero->tagline ?? 'Terpercaya · Resmi · Berizin Kemenag RI' }}</span>
            </div>
            <h1 style="font-size: clamp(1.8rem, 5vw, 4.5rem); line-height: 1.12;">
                {{ $hero->title ?? 'Panggilan Allah Datang — Kami Bantu Anda Menyambutnya' }}
            </h1>
            <p style="font-size: clamp(0.95rem, 2.5vw, 1.3rem); line-height: 1.7; max-width: 60ch;">
                {{ $hero->subtitle ?? 'Elnair Travel menghadirkan paket Haji & Umroh resmi dengan pendampingan penuh — agar setiap doa di Tanah Suci terasa lebih dekat dan bermakna.' }}
            </p>
            <div class="hero-btns-responsive">
                <a href="{{ $hero->btn_primary_url ?? '#cta' }}" class="btn btn-gold hero-btn-item btn-wa-rotator"
                   data-wa-text="Assalamu'alaikum Elnair, saya mau konsultasi paket Haji/Umroh">
                    {{ $hero->btn_primary_text ?? 'Konsultasi Gratis Sekarang' }}
                    <i class="fas fa-arrow-right" aria-hidden="true" style="margin-left:8px;"></i>
                </a>
                <a href="{{ $hero->btn_secondary_url ?? '#paket' }}" class="btn btn-outline hero-btn-item">
                    Lihat Paket
                </a>
            </div>
        </div>
    </div>
    <!-- Integrated Trust Ribbon -->
    <div class="trust-ribbon">
        <div class="container">
            <div class="trust-container">
                @php $trustItems = $hero->trust_items ?? []; @endphp
                @forelse($trustItems as $item)
                <div class="trust-item">
                    @if(!empty($item['url']))
                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="trust-item-wrapper">
                    @endif
                        <i class="{{ $item['icon'] ?? 'fas fa-check-circle' }}" aria-hidden="true"></i>
                        <div class="trust-text">
                            <strong>{{ $item['title'] }}</strong>
                            @if(!empty($item['description']))
                            <p>{{ $item['description'] }}</p>
                            @endif
                            @if(!empty($item['url_label']))
                            <span class="trust-link-btn">{{ $item['url_label'] }} <i class="fas fa-arrow-up-right-from-square" style="font-size:0.65rem; margin-left:3px;"></i></span>
                            @endif
                        </div>
                    @if(!empty($item['url']))
                    </a>
                    @endif
                </div>
                @empty
                {{-- Fallback default items if none configured --}}
                <div class="trust-item">
                    <i class="fas fa-file-circle-check" aria-hidden="true"></i>
                    <div class="trust-text">
                        <strong>Izin Resmi Kemenag</strong>
                        <p>Terdaftar di Kemenag RI</p>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-hand-holding-dollar" aria-hidden="true"></i>
                    <div class="trust-text">
                        <strong>Dana 100% Aman</strong>
                        <p>Rekening Terpisah</p>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-person-dress" aria-hidden="true"></i>
                    <div class="trust-text">
                        <strong>Muthawwif dan Muthawwifah bersertifikat</strong>
                        <p>Bimbing Anda Sepenuh Hati</p>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-spa" aria-hidden="true"></i>
                    <div class="trust-text">
                        <strong>Kenyamanan</strong>
                        <p>Fokus pada Kenyamanan Jamaah</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</header>

<style>
/* ── Women-centred icon accents ───────────────────────────────────────── */
.hero {
    --women-rose: #D98FA3;
    --women-rose-deep: #8B3A50;
    --women-rose-soft: rgba(217, 143, 163, 0.18);
}

.hero .trust-item > i {
    width: 46px !important;
    height: 46px !important;
    min-width: 46px !important;
    border-radius: 16px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #fff !important;
    background: linear-gradient(135deg, #D98FA3 0%, #C08261 100%) !important;
    box-shadow: 0 10px 24px rgba(217,143,163,0.26) !important;
    filter: none !important;
    font-size: 1.15rem !important;
}

[data-theme="dark"] .hero .trust-item > i {
    background: linear-gradient(135deg, rgba(217,143,163,0.24) 0%, rgba(102,165,173,0.16) 100%) !important;
    border: 1px solid rgba(217,143,163,0.3) !important;
    color: #F1C4CE !important;
    box-shadow: 0 10px 24px rgba(0,0,0,0.24) !important;
}

/* ── Hero Buttons — Mobile-first ─────────────────────────────────────── */
.hero-btns-responsive {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.8rem;
    margin-top: 1.5rem;
    width: 100%;
}

.hero-btn-item {
    width: 90%;
    max-width: 320px;
    justify-content: center;
    text-align: center;
    min-height: 48px;
    font-size: 0.85rem;
    font-weight: 700;
    padding: 0.8rem 1rem;
    letter-spacing: 1px;
}

@media (max-width: 768px) {
    .hero-social-proof {
        flex-direction: column;
        justify-content: center;
        text-align: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }
    .hero-proof-text {
        padding-left: 0 !important;
        font-size: 0.75rem !important;
        line-height: 1.4;
    }
}

@media (min-width: 480px) {
    .hero-btns-responsive {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center; /* Center on small tablets */
    }
    .hero-btn-item {
        width: auto;
        min-width: 180px;
        flex: none;
    }
}

@media (min-width: 768px) {
    .hero-btns-responsive {
        justify-content: flex-start; /* Left align on desktop */
    }
    .hero-social-proof {
        justify-content: flex-start;
    }
    .hero-btn-item {
        padding: 1.2rem 2.5rem;
        font-size: 0.95rem;
    }
}

/* ── Dynamic Trust Ribbon — Desktop & Tablet: STRICTLY 1 SINGLE ROW, Mobile: 2 Rows ── */
.trust-ribbon {
    background: rgba(10, 35, 40, 0.92);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    padding: clamp(0.5rem, 0.8vw, 0.85rem) 0;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    margin: 0 !important;
    z-index: 10;
    box-shadow: 0 -10px 35px rgba(0,0,0,0.18);
    overflow: hidden;
}

.hero .container {
    padding-bottom: 0 !important;
}

.trust-container {
    display: flex !important;
    flex-wrap: nowrap !important; /* STRICTLY 1 SINGLE ROW ALWAYS FOR DESKTOP & TABLET */
    justify-content: space-between;
    align-items: center;
    gap: clamp(0.25rem, 0.6vw, 1.1rem);
    width: 100%;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.trust-container::-webkit-scrollbar {
    display: none;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: clamp(0.25rem, 0.5vw, 0.65rem);
    color: white;
    flex: 1 1 0px !important; /* Equal distribution across 1 single line on Desktop & Tablet */
    min-width: 0; /* Allows text to shrink cleanly without wrapping to row 2 */
    padding: 0.15rem clamp(0.15rem, 0.35vw, 0.45rem);
    position: relative;
    transition: all 0.25s ease;
}

/* Subtle vertical separator line between items on Desktop & Tablet */
@media (min-width: 768px) {
    .trust-item:not(:last-child)::after {
        content: '';
        position: absolute;
        right: calc(clamp(0.25rem, 0.6vw, 1.1rem) / -2);
        top: 20%;
        height: 60%;
        width: 1px;
        background: rgba(255, 255, 255, 0.15);
    }
}

.hero .trust-item > i {
    width: clamp(26px, 1.9vw, 36px) !important;
    height: clamp(26px, 1.9vw, 36px) !important;
    min-width: clamp(26px, 1.9vw, 36px) !important;
    border-radius: 9px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #fff !important;
    background: linear-gradient(135deg, #D98FA3 0%, #C08261 100%) !important;
    box-shadow: 0 4px 12px rgba(217,143,163,0.22) !important;
    font-size: clamp(0.72rem, 0.9vw, 1rem) !important;
    flex-shrink: 0 !important;
}

.trust-text {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
}

.trust-text strong {
    font-size: clamp(0.62rem, 0.75vw, 0.82rem);
    font-weight: 700;
    line-height: 1.15;
    color: #ffffff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: 0.1px;
}

.trust-text p {
    font-size: clamp(0.52rem, 0.62vw, 0.70rem);
    margin: 1px 0 0 0;
    opacity: 0.8;
    font-weight: 400;
    line-height: 1.15;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.trust-item-wrapper {
    display: flex;
    align-items: center;
    gap: clamp(0.25rem, 0.5vw, 0.65rem);
    color: inherit;
    text-decoration: none;
    width: 100%;
    min-width: 0;
}

.trust-item:hover {
    transform: translateY(-2px);
}

.trust-link-btn {
    display: inline-block;
    font-size: 0.65rem;
    color: var(--brand-teal);
    font-weight: 700;
    margin-top: 1px;
    letter-spacing: 0.2px;
    white-space: nowrap;
}

/* ── Mobile Layout (<= 767px): Anchored at Bottom Edge, 2 Rows Grid, Clean Typography ── */
@media (max-width: 767px) {
    .hero .container {
        padding-bottom: clamp(75px, 12vh, 95px) !important;
        padding-top: 2rem !important;
    }
    .trust-ribbon {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0.6rem 0 !important;
        background: rgba(10, 35, 40, 0.94) !important;
        backdrop-filter: blur(25px) !important;
        -webkit-backdrop-filter: blur(25px) !important;
        border-radius: 0 !important;
        border: none !important;
        border-top: 1px solid rgba(255, 255, 255, 0.14) !important;
        box-shadow: 0 -10px 30px rgba(0,0,0,0.25) !important;
        z-index: 10 !important;
        overflow: hidden !important;
    }
    .trust-ribbon .container {
        padding: 0 0.75rem !important;
        max-width: 100% !important;
    }
    .trust-container {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important; /* 6 items cleanly divide into 2 rows of 3 columns */
        gap: 0.45rem 0.35rem !important;
        padding: 0 !important;
        width: 100% !important;
        overflow: visible !important;
        align-items: center !important;
    }
    .trust-item {
        flex: none !important;
        min-width: 0 !important;
        padding: 0.15rem 0.2rem !important;
        gap: 0.35rem !important;
        display: flex !important;
        align-items: center !important;
    }
    .trust-item::after {
        display: none !important;
    }
    .hero .trust-item > i {
        width: 26px !important;
        height: 26px !important;
        min-width: 26px !important;
        font-size: 0.75rem !important;
        border-radius: 7px !important;
        flex-shrink: 0 !important;
    }
    .trust-text {
        min-width: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
    }
    .trust-text strong {
        font-size: clamp(0.6rem, 2.2vw, 0.72rem) !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        white-space: normal !important; /* Allow natural wrapping so words are never cut off */
        word-break: break-word !important;
        line-height: 1.18 !important;
        letter-spacing: 0.1px !important;
        display: block !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    .trust-text p {
        display: none !important; /* Hide tiny truncated descriptions on mobile for maximum cleanliness */
    }
}

@media (max-width: 380px) {
    .trust-ribbon .container {
        padding: 0 0.4rem !important;
    }
    .trust-container {
        gap: 0.35rem 0.25rem !important;
    }
    .hero .trust-item > i {
        width: 22px !important;
        height: 22px !important;
        min-width: 22px !important;
        font-size: 0.65rem !important;
        border-radius: 6px !important;
    }
    .trust-text strong {
        font-size: 0.58rem !important;
        line-height: 1.15 !important;
    }
}

/* ── Hero Slideshow ─────────────────────────────────────── */
.hero-slideshow {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    overflow: hidden;
}
.hero-slideshow .slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1.5s ease-in-out;
}
.hero-slideshow .slide.active {
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slideshow .slide');
    if (slides.length <= 1) return;
    
    let currentSlide = 0;
    
    // Auto-advance slides every 5 seconds
    setInterval(() => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }, 5000);
});
</script>

