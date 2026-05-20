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
        });
    </script>


    <script src="{{ asset('assets/js/script.js') }}" defer></script>

    <script src="{{ asset('assets/js/pixel-tracker.js') }}" defer></script>
    
    @stack('scripts')
</body>
</html>
