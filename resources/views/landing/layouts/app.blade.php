<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Elnair Travel' }} - {{ $page_title ?? 'Perjalanan Suci Eksklusif' }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $meta_description ?? ($settings['meta_description'] ?? 'Elnair Travel') }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? 'umrah, haji, travel, ibadah, eksklusif' }}">
    <meta name="author" content="{{ $settings['site_name'] ?? 'Elnair Travel' }}">
    
    <!-- Performance Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @isset($settings['favicon'])
    <link rel="shortcut icon" href="{{ asset($settings['favicon']) }}" type="image/x-icon">
    @endisset

    <!-- Advertising & Analytics Pixels (async, non-blocking) -->
    {{-- Reads META_PIXEL_ID, GOOGLE_TAG_MANAGER_ID, GA4_MEASUREMENT_ID, TIKTOK_PIXEL_ID from .env --}}
    <x-advertising-pixels />

    @yield('custom_pixel')

    <!-- SEO Schema.org (Organization) -->
    <script type="application/ld+json">
    {!! $orgSchema !!}
    </script>
</head>
<body class="{{ Request::is('/') ? 'homepage-root' : 'innerpage-root' }}">

    {{-- GTM noscript fallback (pushed by x-advertising-pixels component) --}}
    @stack('gtm_body')

    @include('landing.sections.navbar.index')

    <main>
        @yield('content')
    </main>

    @include('landing.sections.footer.index')

    {{-- ── Sticky Bottom CTA Bar (muncul setelah scroll 30%) ─────────── --}}
    <div id="stickyCtaBar" class="sticky-cta-bar" aria-live="polite">
        <div class="sticky-cta-inner">
            <div class="sticky-cta-left">
                <span class="sticky-online-dot"></span>
                <span class="sticky-cta-text">
                    <strong>Tim kami online sekarang</strong>
                    <small>Konsultasi gratis, tanpa kewajiban</small>
                </span>
            </div>
            <a href="#" class="btn btn-gold sticky-cta-btn btn-wa-rotator"
               data-wa-text="Halo Elnair, saya ingin konsultasi paket Haji/Umroh">
                <i class="fab fa-whatsapp" style="margin-right:6px;"></i> Chat Sekarang
            </a>
            <button class="sticky-cta-close" id="stickyCtaClose" aria-label="Tutup">×</button>
        </div>
    </div>

    <style>
    /* ── Sticky CTA Bar ────────────────────────────────────────────────── */
    .sticky-cta-bar {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        z-index: 9998;
        background: var(--brand-dark);
        border-top: 2px solid var(--brand-gold);
        transform: translateY(100%);
        transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 -8px 40px rgba(0,0,0,0.25);
    }
    .sticky-cta-bar.visible {
        transform: translateY(0);
    }
    .sticky-cta-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0.85rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .sticky-cta-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: white;
    }
    .sticky-online-dot {
        width: 10px;
        height: 10px;
        background: #25D366;
        border-radius: 50%;
        flex-shrink: 0;
        animation: onlinePulse 1.8s ease-in-out infinite;
    }
    @keyframes onlinePulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(37,211,102,0.6); }
        50% { box-shadow: 0 0 0 6px rgba(37,211,102,0); }
    }
    .sticky-cta-text { display: flex; flex-direction: column; }
    .sticky-cta-text strong { font-size: 0.9rem; color: white; }
    .sticky-cta-text small { font-size: 0.72rem; opacity: 0.75; color: rgba(255,255,255,0.8); }
    .sticky-cta-btn {
        padding: 0.7rem 1.8rem !important;
        font-size: 0.82rem !important;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .sticky-cta-close {
        background: none;
        border: none;
        color: rgba(255,255,255,0.5);
        font-size: 1.4rem;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
        transition: color 0.2s;
        flex-shrink: 0;
    }
    .sticky-cta-close:hover { color: white; }

    @media (max-width: 480px) {
        .floating-wa-label { display: none; }
        .floating-wa-btn { padding: 14px; border-radius: 50%; bottom: 80px; }
        .sticky-cta-text small { display: none; }
    }
    </style>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // WA Rotator Logic
            const waRaw = "{{ $settings['wa_number'] ?? '6281234567890' }}";
            const waNumbers = waRaw.split(',').map(n => n.replace(/[^0-9]/g, '').trim()).filter(n => n);
            
            const defaultText = encodeURIComponent("Assalamu'alaikum, saya ingin konsultasi paket Elnair");
            
            function getRandomWaUrl(text = defaultText) {
                if (waNumbers.length === 0) return '#';
                const randomIndex = Math.floor(Math.random() * waNumbers.length);
                return `https://wa.me/${waNumbers[randomIndex]}?text=${text}`;
            }

            // Apply to floating button
            const floatingBtn = document.getElementById('waRotatorBtn');
            if (floatingBtn) {
                floatingBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.open(getRandomWaUrl(), '_blank');
                });
            }

            // Apply to any other button with class .btn-wa-rotator (optional)
            const otherWaBtns = document.querySelectorAll('.btn-wa-rotator');
            otherWaBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let customText = btn.getAttribute('data-wa-text');
                    window.open(getRandomWaUrl(customText ? encodeURIComponent(customText) : defaultText), '_blank');
                });
            });

            // ── Sticky CTA Bar: tampil setelah scroll 30% halaman ──────────
            const stickyBar = document.getElementById('stickyCtaBar');
            const stickyClose = document.getElementById('stickyCtaClose');
            let stickyDismissed = sessionStorage.getItem('stickyCtaDismissed');

            if (stickyBar && !stickyDismissed) {
                window.addEventListener('scroll', function () {
                    const scrollPct = window.scrollY / (document.body.scrollHeight - window.innerHeight);
                    if (scrollPct > 0.30) {
                        stickyBar.classList.add('visible');
                    }
                }, { passive: true });
            }
            if (stickyClose && stickyBar) {
                stickyClose.addEventListener('click', function () {
                    stickyBar.classList.remove('visible');
                    sessionStorage.setItem('stickyCtaDismissed', '1');
                });
            }

            // ── Scarcity: warnai badge "Sisa X Seat" merah jika ≤5 ────────
            document.querySelectorAll('.schedule-status span:last-child').forEach(el => {
                const m = el.textContent.match(/\d+/);
                if (m && parseInt(m[0]) <= 5) {
                    el.style.color = '#e74c3c';
                    el.style.fontWeight = '800';
                    const badge = el.closest('.schedule-status')?.querySelector('span:first-child');
                    if (badge) {
                        badge.style.background = 'rgba(231,76,60,0.15)';
                        badge.style.color = '#e74c3c';
                    }
                }
            });
        });
    </script>


    <script src="{{ asset('assets/js/script.js') }}" defer></script>

    <script src="{{ asset('assets/js/pixel-tracker.js') }}" defer></script>
    
    @stack('scripts')
</body>
</html>
