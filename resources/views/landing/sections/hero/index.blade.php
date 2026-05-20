{{-- 
    Hero Section — Mobile-first Responsive
    - h1 font-size: clamp() to prevent overflow on mobile portrait
    - .hero-btns: flex-col on mobile, flex-row on sm+
    - Buttons: min-height 48px (tap target), w-full on mobile
    - Hero background: eager loading (LCP element), explicit height with aspect-ratio
--}}

<!-- Luxury Hero -->
<header class="hero" id="home">
    <div class="hero-bg-img" style="background-image: url('{{ asset('assets/img/hero-premium.png') }}'); opacity: 0.7;"></div>
    <div class="container">
        <div class="hero-content reveal active">
            <div class="hero-badge">
                <i class="fas fa-star-and-crescent" aria-hidden="true"></i>
                <span>{{ $hero->tagline ?? 'Perjalanan Ibadah yang Berkarakter' }}</span>
            </div>
            <h1 style="font-size: clamp(1.8rem, 5vw, 4.5rem); line-height: 1.12;">
                {{ $hero->title ?? 'Wujudkan Perjalanan Suci Impian Anda' }}
            </h1>
            <p style="font-size: clamp(0.95rem, 2.5vw, 1.3rem); line-height: 1.7; max-width: 60ch;">
                {{ $hero->subtitle ?? 'Menghadirkan harmoni antara ibadah yang khusyuk dan kenyamanan yang tak tertandingi di Tanah Suci.' }}
            </p>
            <div class="hero-btns-responsive">
                <a href="{{ $hero->btn_primary_url ?? '#cta' }}" class="btn btn-gold hero-btn-item">
                    {{ $hero->btn_primary_text ?? 'Mulai Konsultasi' }}
                    <i class="fas fa-arrow-right" aria-hidden="true" style="margin-left:8px;"></i>
                </a>
                <a href="{{ $hero->btn_secondary_url ?? '#paket' }}" class="btn btn-outline hero-btn-item">
                    Eksplorasi Paket
                </a>
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
                            <h4>Amanah & Resmi</h4>
                            <p>{{ $settings['ppiu_number'] ?? 'Terdaftar di Kemenag RI' }} <i class="fas fa-external-link-alt" style="font-size: 0.6rem; margin-left: 3px;" aria-hidden="true"></i></p>
                        </div>
                    @if(isset($settings['ppiu_url']) && $settings['ppiu_url'] != '')
                    </a>
                    @endif
                </div>
                <div class="trust-item">
                    <i class="fas fa-shield-check" aria-hidden="true"></i>
                    <div class="trust-text">
                        <h4>Keamanan Dana</h4>
                        <p>Sistem Terproteksi</p>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                    <div class="trust-text">
                        <h4>Pembimbing Ahli</h4>
                        <p>Muthawwif Berpengalaman</p>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <div class="trust-text">
                        <h4>Layanan Bintang 5</h4>
                        <p>Prioritas Kenyamanan</p>
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
    flex-direction: column;       /* Mobile: stacked, full-width */
    gap: 0.875rem;
    margin-top: 2rem;
}

.hero-btn-item {
    width: 100%;
    justify-content: center;
    text-align: center;
    min-height: 52px;             /* iOS/Android minimum tap target */
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
}

@media (min-width: 480px) {
    .hero-btns-responsive {
        flex-direction: row;
        flex-wrap: wrap;
    }
    .hero-btn-item {
        width: auto;
        min-width: 180px;
        flex: none;
    }
}

@media (min-width: 768px) {
    .hero-btn-item {
        padding: 1.2rem 2.5rem;
        font-size: 1.05rem;
    }
}
</style>

