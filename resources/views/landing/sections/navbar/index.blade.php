<!-- Navbar -->
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
            <a href="{{ route('paket.index') }}?type=umroh" wire:navigate>Paket Umrah</a>
            <a href="{{ route('jadwal.index') }}" wire:navigate>Jadwal</a>
        </div>
        <div class="nav-cta">
            <button id="theme-toggle" class="theme-btn" aria-label="Toggle Theme">
                <i class="fas fa-moon"></i>
            </button>
            <a href="https://wa.me/{{ $settings['wa_number'] ?? '' }}" class="btn btn-gold btn-wa-rotator wa-cta-btn"
               data-wa-text="Assalamu'alaikum Elnair, saya ingin konsultasi paket"
               style="display: flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.5rem; border-radius: 50px; font-weight: 700; font-size: 0.75rem; text-decoration: none; position: relative; transition: all 0.3s ease;">
                <i class="fab fa-whatsapp" style="font-size: 1.1rem;"></i>
                <span>Konsultasi Gratis</span>
                
                <!-- Notification Dot -->
                <span style="position:absolute; top:-2px; right:-2px; background:#dc3545; border-radius:50%; width:12px; height:12px; border:2px solid white; box-sizing:border-box; animation: wa-pulse 2s infinite;"></span>
                
                <!-- Hover Message Bubble -->
                <div class="wa-hover-bubble">
                    Kami siap untuk memberikan solusi perjalanan Anda. Chat sekarang!
                </div>
                
                <style>
                    @keyframes wa-pulse {
                        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
                        70% { box-shadow: 0 0 0 6px rgba(220, 53, 69, 0); }
                        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
                    }
                    
                    /* Bubble Styling */
                    .wa-hover-bubble {
                        position: absolute;
                        top: calc(100% + 15px);
                        right: 0;
                        width: 220px;
                        background: var(--brand-dark);
                        color: #ffffff;
                        padding: 0.8rem 1rem;
                        border-radius: 25px 0 25px 25px; /* Sharp top-right */
                        font-size: 0.75rem;
                        font-weight: 500;
                        line-height: 1.5;
                        box-shadow: 0 10px 25px rgba(13, 76, 84, 0.4);
                        opacity: 0;
                        visibility: hidden;
                        transform: translateY(10px) scale(0.95);
                        transform-origin: top right;
                        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                        z-index: 100;
                        pointer-events: none;
                        text-align: center;
                        white-space: normal;
                    }
                    /* Bubble Triangle - perfectly flush to the corner */
                    .wa-hover-bubble::before {
                        content: '';
                        position: absolute;
                        top: -12px;
                        right: 0;
                        width: 24px;
                        height: 12px;
                        background: var(--brand-dark);
                        clip-path: polygon(100% 0, 0 100%, 100% 100%);
                    }
                    /* Show Bubble on Hover */
                    .wa-cta-btn:hover .wa-hover-bubble {
                        opacity: 1;
                        visibility: visible;
                        transform: translateY(0) scale(1);
                    }
                </style>
            </a>
        </div>
    </div>
</nav>
