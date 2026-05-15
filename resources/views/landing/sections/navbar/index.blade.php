<!-- Elite Navbar -->
<nav id="navbar">
    <div class="container nav-content">
        <div class="logo">
            <picture>
                <source srcset="{{ asset('assets/img/logo-mobile.png') }}" media="(max-width: 768px)">
                <img src="{{ asset($settings['logo'] ?? 'assets/img/logo-full.png') }}" alt="Elnair Logo" class="brand-logo" loading="lazy">
            </picture>
        </div>
        <div class="nav-links">
            <a href="{{ route('landing.page', 'haji') }}">Haji</a>
            <a href="{{ route('landing.page', 'umroh') }}">Umroh</a>
        </div>
        <div class="nav-cta">
            <button id="theme-toggle" class="theme-btn" aria-label="Toggle Theme">
                <i class="fas fa-moon"></i>
            </button>
            <a href="https://wa.me/{{ $settings['wa_number'] ?? '' }}" class="btn btn-gold" style="padding: 0.8rem 2rem; font-size: 0.7rem;">Book Now</a>
        </div>
    </div>
</nav>
