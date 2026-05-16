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

    <!-- Marketing Scripts -->
    {!! $settings['google_analytics'] ?? '' !!}
    {!! $settings['facebook_pixel'] ?? '' !!}

    <!-- SEO Schema.org (Organization) -->
    <script type="application/ld+json">
    {!! $orgSchema !!}
    </script>
</head>
<body>

    @include('landing.sections.navbar.index')

    <main>
        @yield('content')
    </main>

    @include('landing.sections.footer.index')

    <script src="{{ asset('assets/js/script.js') }}" defer></script>
    <script src="{{ asset('assets/js/pixel-tracker.js') }}" defer></script>
    
    @stack('scripts')
</body>
</html>
