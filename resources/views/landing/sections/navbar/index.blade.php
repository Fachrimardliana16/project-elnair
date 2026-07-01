<!-- Elite Navbar -->
<nav id="navbar">
    <div class="container nav-content">
        <a href="{{ route('home') }}" class="logo" style="text-decoration: none;">
            <picture>
                <source srcset="{{ asset('assets/img/logo-mobile.webp') }}" type="image/webp" media="(max-width: 768px)">
                <source srcset="{{ asset('assets/img/logo-mobile.webp') }}" media="(max-width: 768px)">
                <source srcset="{{ asset(str_replace('.png', '.webp', $settings['logo'] ?? 'assets/img/logo-full.webp')) }}" type="image/webp">
                <img src="{{ asset($settings['logo'] ?? 'assets/img/logo-full.webp') }}" alt="Elnair Logo" class="brand-logo" width="180" height="180" loading="eager" fetchpriority="high" decoding="sync">
            </picture>
        </a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('paket.index') }}?type=haji" wire:navigate>Haji</a>
            <a href="{{ route('paket.index') }}?type=umroh" wire:navigate>Umroh</a>
        </div>
        <div class="nav-cta">
            <button id="theme-toggle" class="theme-btn" aria-label="Toggle Theme">
                <i class="fas fa-moon"></i>
            </button>
            <a href="https://wa.me/{{ $settings['wa_number'] ?? '' }}" class="btn btn-gold btn-wa-rotator"
               data-wa-text="Assalamu'alaikum Elnair, saya ingin konsultasi paket"
               style="padding: 0.8rem 2rem; font-size: 0.7rem; position:relative;">
                <span style="position:absolute;top:-6px;right:-6px;background:#dc3545;color:white;border-radius:50%;width:18px;height:18px;font-size:0.6rem;font-weight:900;display:flex;align-items:center;justify-content:center;border:2px solid white;">!</span>
                Konsultasi Gratis
            </a>
        </div>
    </div>
</nav>
