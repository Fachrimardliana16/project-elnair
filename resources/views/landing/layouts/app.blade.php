<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Elnair Travel' }} - Perjalanan Suci Eksklusif</title>
    
    <!-- Performance Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @if(isset($settings['favicon']))
    <link rel="shortcut icon" href="{{ asset($settings['favicon']) }}" type="image/x-icon">
    @endif
</head>
<body>

    @include('landing.sections.navbar.index')

    <main>
        @yield('content')
    </main>

    @include('landing.sections.footer.index')

    <script src="{{ asset('assets/js/script.js') }}" defer></script>
</body>
</html>
