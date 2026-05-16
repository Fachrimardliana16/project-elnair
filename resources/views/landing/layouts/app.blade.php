<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Elnair Travel' }} - {{ $page_title ?? 'Perjalanan Suci Eksklusif' }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $meta_description ?? ($settings['meta_description'] ?? 'Elnair Travel menyediakan perjalanan ibadah Umrah dan Haji premium dengan layanan eksklusif.') }}">
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

    <!-- Marketing Scripts (GA & FB Pixel) -->
    {!! $settings['google_analytics'] ?? '' !!}
    {!! $settings['facebook_pixel'] ?? '' !!}

    <!-- SEO Schema.org (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "{{ $settings['site_name'] ?? 'Elnair Travel' }}",
      "url": "{{ url('/') }}",
      "logo": "{{ asset($settings['logo'] ?? 'assets/img/logo-full.png') }}",
      "sameAs": [
        "{{ $settings['facebook_url'] ?? '' }}",
        "{{ $settings['instagram_url'] ?? '' }}"
      ]
    }
    </script>
</head>
<body>

    @include('landing.sections.navbar.index')

    <main>
        @yield('content')
    </main>

    @include('landing.sections.footer.index')

    <script src="{{ asset('assets/js/script.js') }}" defer></script>
    
    <!-- Smart Pixel Event Tracker -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Track WhatsApp Clicks as Leads
            document.querySelectorAll('a[href*="wa.me"]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (typeof fbq !== 'undefined') {
                        fbq('track', 'Contact');
                        fbq('track', 'Lead', {
                            content_name: 'WhatsApp Inquiry',
                            content_category: 'Communication'
                        });
                    }
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'generate_lead', {
                            'event_category': 'engagement',
                            'event_label': 'WhatsApp'
                        });
                    }
                });
            });

            // Track Package View / Interest
            document.querySelectorAll('a[href*="#paket"]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (typeof fbq !== 'undefined') {
                        fbq('track', 'ViewContent', {
                            content_name: 'Packages Section'
                        });
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
