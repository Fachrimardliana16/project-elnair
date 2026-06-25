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
    
    {{-- Preload logo-mobile.webp: <picture><source media> is NOT scanned by the browser preload scanner,
         so without this explicit preload the logo download is delayed 3,000+ ms (discovered only when
         the HTML parser reaches the <picture> in the body). imagesrcset + media mirrors the <source> condition. --}}
    <link rel="preload" as="image"
          imagesrcset="{{ asset('assets/img/logo-mobile.webp') }}"
          imagesizes="180px"
          media="(max-width: 768px)"
          fetchpriority="high">

    {{-- Preload hero LCP image --}}
    <link rel="preload" as="image" href="{{ asset('assets/img/hero-premium.webp') }}" fetchpriority="high">

    {{-- Preload self-hosted fonts (same-origin = no cross-origin DNS penalty, no GDPR 3rd-party request)
         Playfair Display 700-900 latin — critical: used by h1 LCP element
         Outfit latin — body text font --}}
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('assets/fonts/playfair-display-700-900-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('assets/fonts/outfit-latin.woff2') }}">

    {{-- Preload FA woff2 fonts (self-hosted, same origin — arrives fast) --}}
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('assets/webfonts/fa-solid-900.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('assets/webfonts/fa-brands-400.woff2') }}">

    {{-- Inline critical above-fold CSS: variables, reset, hero, nav --}}
    {{-- FA font-display:swap override — points to self-hosted fonts (same origin = fast) --}}
    <style>
    @font-face{font-family:'Playfair Display';font-style:normal;font-weight:700 900;font-display:optional;src:url("{{ asset('assets/fonts/playfair-display-700-900-latin-ext.woff2') }}") format('woff2');unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB}
    @font-face{font-family:'Playfair Display';font-style:normal;font-weight:700 900;font-display:optional;src:url("{{ asset('assets/fonts/playfair-display-700-900-latin.woff2') }}") format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
    @font-face{font-family:'Playfair Display Fallback';src:local('Georgia'),local('Times New Roman'),local('serif');size-adjust:112%;ascent-override:85%;descent-override:22%;line-gap-override:0%}
    @font-face{font-family:'Outfit Fallback';src:local('Arial'),local('Helvetica Neue'),local('sans-serif');size-adjust:97%;ascent-override:105%;descent-override:35%;line-gap-override:0%}
    @font-face{font-family:'Outfit';font-style:normal;font-weight:300 700;font-display:block;src:url("{{ asset('assets/fonts/outfit-latin-ext.woff2') }}") format('woff2');unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C0,U+2113,U+2C60-2C7F,U+A720-A7FF}
    @font-face{font-family:'Outfit';font-style:normal;font-weight:300 700;font-display:block;src:url("{{ asset('assets/fonts/outfit-latin.woff2') }}") format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
    @font-face{font-family:"Font Awesome 6 Free";font-display:block;font-weight:900;src:url("{{ asset('assets/webfonts/fa-solid-900.woff2') }}") format("woff2")}
    @font-face{font-family:"Font Awesome 6 Free";font-display:block;font-weight:400;src:url("{{ asset('assets/webfonts/fa-regular-400.woff2') }}") format("woff2")}
    @font-face{font-family:"Font Awesome 6 Brands";font-display:block;font-weight:400;src:url("{{ asset('assets/webfonts/fa-brands-400.woff2') }}") format("woff2")}
    :root{--brand-dark:#0D4C54;--brand-teal:#66A5AD;--brand-gold:#8B5E3C;--brand-peach:#C08261;--brand-beige:#DCD0C0;--bg-silk:#FDFBF9;--text-dark:#1A1A1A;--card-bg:#fff;--section-white:#fff;--gold-gradient:linear-gradient(135deg,#8B5E3C 0%,#C08261 100%);--shadow-elite:0 20px 50px rgba(13,76,84,.15);--transition-elite:transform .6s cubic-bezier(.16,1,.3,1),opacity .6s cubic-bezier(.16,1,.3,1)}
    [data-theme="dark"]{--bg-silk:#0C1517;--text-dark:#E2E8E9;--brand-dark:#7BBFC8;--card-bg:#14201F;--section-white:#0C1517}
    *{margin:0;padding:0;box-sizing:border-box}
    html{scroll-behavior:smooth}
    @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}}
    @media(max-width:768px){nav.scrolled{backdrop-filter:none;background:rgba(255,255,255,.96)}.trust-ribbon{backdrop-filter:none;background:rgba(13,76,84,.97)}.hero-badge{backdrop-filter:none;background:rgba(0,0,0,.3)}.homepage-root section,.homepage-root header{height:100vh;padding:20px 0}}
    body{font-family:'Outfit','Outfit Fallback',sans-serif;background-color:var(--bg-silk);color:var(--text-dark);overflow-x:hidden}
    .homepage-root section,.homepage-root header{height:100vh;display:flex;flex-direction:column;justify-content:center;position:relative;padding:0;overflow:hidden}
    .container{max-width:1300px;margin:0 auto;padding:0 2rem;width:100%}
    nav{position:fixed;top:0;left:0;width:100%;z-index:1000;height:80px;display:flex;align-items:center;transition:transform .5s cubic-bezier(.16,1,.3,1),background .5s;will-change:transform}
    nav.nav-hidden{transform:translateY(-100%)}
    nav.scrolled{background:rgba(255,255,255,.9);backdrop-filter:blur(20px);box-shadow:0 5px 30px rgba(0,0,0,.05)}
    .nav-content{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;width:100%}
    .brand-logo{height:180px;width:auto;filter:drop-shadow(0 0 18px rgba(255,255,255,.6)) drop-shadow(0 5px 20px rgba(0,0,0,.3));transform:translateY(15px)}
    .logo{position:relative;z-index:10;display:flex;align-items:center}
    .hero{background:var(--brand-dark);color:#fff;text-align:left;overflow:hidden}
    .hero-bg-img{position:absolute;top:0;left:0;width:100%;height:100%;background-size:cover;background-position:center;z-index:0}
    .hero .container{position:relative;z-index:2}
    .hero h1{font-family:'Playfair Display','Playfair Display Fallback',serif;font-size:clamp(2rem,8vw,4.5rem);font-weight:900;line-height:1.1;margin-bottom:1.5rem;max-width:850px;letter-spacing:-1px}
    .hero p{font-size:clamp(.9rem,3vw,1.2rem);line-height:1.6;margin-bottom:2.5rem;max-width:650px;opacity:.9}
    .hero-badge{display:inline-flex;align-items:center;gap:.8rem;background:rgba(255,255,255,.1);padding:.6rem 1.4rem;border-radius:50px;backdrop-filter:blur(15px);border:1px solid rgba(255,255,255,.2);margin-bottom:2rem}
    .btn{display:inline-flex;align-items:center;padding:1.2rem 2.8rem;border-radius:50px;text-decoration:none;font-weight:700;letter-spacing:2px;text-transform:uppercase;font-size:.85rem;transition:var(--transition-elite)}
    .btn-gold{background:var(--gold-gradient);color:#fff;box-shadow:0 15px 35px rgba(139,94,60,.3)}
    .btn-outline{border:2px solid #fff;color:#fff}
    .hero-btns{display:flex;gap:1.5rem;flex-wrap:wrap;margin-top:1rem}
    .trust-ribbon{background:rgba(13,76,84,.85);backdrop-filter:blur(30px);padding:1.5rem 0;border-top:1px solid rgba(255,255,255,.1);position:absolute;bottom:0;width:100%;z-index:10}
    .trust-container{display:flex;justify-content:space-between;align-items:center;gap:2rem}
    .trust-item{display:flex;align-items:center;gap:1.2rem;color:#fff}
    .trust-text strong{font-size:.9rem;margin:0;font-weight:700;letter-spacing:.5px;display:block}
    .trust-text p{font-size:.75rem;margin:0;opacity:.7;font-weight:400}
    .trust-item i{min-width:1.25em;width:1.25em;height:1em;line-height:1;display:inline-block;text-align:center;flex-shrink:0;font-style:normal;font-variant:normal;text-rendering:auto}
    .fas,.far,.fab,.fa-solid,.fa-regular,.fa-brands{display:inline-block;font-style:normal;font-variant:normal;line-height:1;text-rendering:auto}
    </style>

    {{-- Full stylesheet: async (non-blocking) — CLS is 0 since 100dvh→100vh is fixed in both
         inline critical CSS and style.css, so async loading is safe. Saves ~680ms FCP. --}}
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"></noscript>

    {{-- Font Awesome: subsetted CSS — only 25 icons used on this page (was 1856 icons = 98 KiB).
         fa-subset.min.css = 14.5 KiB vs 98 KiB original → 85% reduction in unused CSS. --}}
    <link rel="preload" as="style"
          href="{{ asset('assets/css/fa/fa-subset.min.css') }}"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('assets/css/fa/fa-subset.min.css') }}"></noscript>
    
    @isset($settings['favicon'])
    @php
        $faviconPath = public_path($settings['favicon']);
        $faviconCacheBuster = file_exists($faviconPath) ? '?v=' . filemtime($faviconPath) : '';
        $faviconMime = str_ends_with($settings['favicon'], '.webp') ? 'image/webp' : (str_ends_with($settings['favicon'], '.png') ? 'image/png' : 'image/x-icon');
    @endphp
    <link rel="shortcut icon" href="{{ asset($settings['favicon']) }}{{ $faviconCacheBuster }}" type="{{ $faviconMime }}">
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

    @if(($settings['show_sticky_cta_bar'] ?? '1') == '1')
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
    @endif

    {{-- Sticky CTA Bar removed from mobile, leaving WA rotator --}}

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
        will-change: transform;
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
        position: relative;
    }
    .sticky-online-dot::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: #25D366;
        animation: onlinePulse 1.8s ease-in-out infinite;
        will-change: transform, opacity;
    }
    @keyframes onlinePulse {
        0%, 100% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(2.8); opacity: 0; }
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
                let docHeight = document.body.scrollHeight - window.innerHeight;
                window.addEventListener('resize', function() {
                    docHeight = document.body.scrollHeight - window.innerHeight;
                }, { passive: true });
                
                let ticking = false;
                window.addEventListener('scroll', function () {
                    if (!ticking) {
                        window.requestAnimationFrame(function() {
                            if (docHeight > 0) {
                                const scrollPct = window.scrollY / docHeight;
                                if (scrollPct > 0.30) {
                                    stickyBar.classList.add('visible');
                                }
                            }
                            ticking = false;
                        });
                        ticking = true;
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

    <script src="{{ asset('assets/js/script.js') }}?v={{ time() }}" defer></script>

    <script src="{{ asset('assets/js/pixel-tracker.js') }}" defer></script>
    
    @stack('scripts')
</body>
</html>
