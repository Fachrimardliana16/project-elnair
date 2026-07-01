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
                <i class="fas fa-star-and-crescent" aria-hidden="true"></i>
                <span>{{ $hero->tagline ?? 'Terpercaya · Resmi · Berizin Kemenag RI' }}</span>
            </div>
            <h1 style="font-size: clamp(1.8rem, 5vw, 4.5rem); line-height: 1.12;">
                {{ $hero->title ?? 'Panggilan Allah Datang — Kami Bantu Anda Menyambutnya' }}
            </h1>
            <p style="font-size: clamp(0.95rem, 2.5vw, 1.3rem); line-height: 1.7; max-width: 60ch;">
                {{ $hero->subtitle ?? 'Elnair Travel menghadirkan paket Haji & Umroh resmi dengan pendampingan penuh — agar setiap doa di Tanah Suci terasa lebih dekat dan bermakna.' }}
            </p>
            <div class="hero-btns-responsive">
                @if(($settings['show_pendaftaran_feature'] ?? '1') == '1')
                <a href="{{ route('pendaftaran.create') }}" class="btn btn-gold hero-btn-item" style="background: var(--brand-teal); border-color: var(--brand-teal); color: white;">
                    <i class="fas fa-user-plus" aria-hidden="true" style="margin-right:8px;"></i> Daftar Jamaah
                </a>
                @endif
                <a href="{{ $hero->btn_primary_url ?? '#cta' }}" class="btn btn-gold hero-btn-item btn-wa-rotator"
                   data-wa-text="Assalamu'alaikum Elnair, saya mau konsultasi paket Haji/Umroh">
                    {{ $hero->btn_primary_text ?? 'Konsultasi Gratis Sekarang' }}
                    <i class="fas fa-arrow-right" aria-hidden="true" style="margin-left:8px;"></i>
                </a>
                <a href="{{ $hero->btn_secondary_url ?? '#paket' }}" class="btn btn-outline hero-btn-item">
                    Lihat Paket
                </a>
            </div>
            <div class="hero-social-proof">
                <div class="hero-proof-avatars">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><circle cx="16" cy="16" r="16" fill="#c8a96e"/><circle cx="16" cy="13" r="6" fill="#fff" opacity=".8"/><ellipse cx="16" cy="28" rx="10" ry="7" fill="#fff" opacity=".8"/></svg>
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><circle cx="16" cy="16" r="16" fill="#a0784a"/><circle cx="16" cy="13" r="6" fill="#fff" opacity=".8"/><ellipse cx="16" cy="28" rx="10" ry="7" fill="#fff" opacity=".8"/></svg>
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><circle cx="16" cy="16" r="16" fill="#d4b483"/><circle cx="16" cy="13" r="6" fill="#fff" opacity=".8"/><ellipse cx="16" cy="28" rx="10" ry="7" fill="#fff" opacity=".8"/></svg>
                </div>
                <span class="hero-proof-text">
                    Jamaah telah mempercayakan perjalanan sucinya kepada kami
                </span>
            </div>
        </div>
    </div>
    <!-- Integrated Trust Ribbon -->
    <div class="trust-ribbon">
        <div class="container">
            <div class="trust-container">
                <div class="trust-item">
                    @if(isset($settings['ppiu_url']) && $settings['ppiu_url'] != '')
                    <a href="{{ $settings['ppiu_url'] }}" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; color: inherit; text-decoration: none;">
                    @endif
                        <i class="fas fa-certificate" aria-hidden="true"></i>
                        <div class="trust-text">
                            <strong>Izin Resmi Kemenag</strong>
                            <p>{{ $settings['ppiu_number'] ?? 'Terdaftar di Kemenag RI' }} <i class="fas fa-external-link-alt" style="font-size: 0.6rem; margin-left: 3px;" aria-hidden="true"></i></p>
                        </div>
                    @if(isset($settings['ppiu_url']) && $settings['ppiu_url'] != '')
                    </a>
                    @endif
                </div>
                <div class="trust-item">
                    <i class="fas fa-shield-alt" aria-hidden="true"></i>
                    <div class="trust-text">
                        <strong>Dana 100% Aman</strong>
                        <p>Rekening Terpisah</p>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                    <div class="trust-text">
                        <strong>Muthawwif Bersertifikat</strong>
                        <p>Bimbing Anda Sepenuh Hati</p>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <div class="trust-text">
                        <strong>Kenyamanan</strong>
                        <p>Fokus pada Kenyamanan Jamaah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
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

