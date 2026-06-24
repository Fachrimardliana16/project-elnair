<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Elnair Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-dark: #0D4C54;
            --brand-gold: #8B5E3C;
            --brand-beige: #DCD0C0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, var(--brand-dark) 0%, #0a3840 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 2rem;
        }
        .error-container {
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .error-icon {
            font-size: 5rem;
            color: var(--brand-gold);
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        .error-code {
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            font-weight: 700;
            color: rgba(255,255,255,0.15);
            line-height: 1;
            margin-bottom: -1rem;
            letter-spacing: -5px;
        }
        .error-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: white;
            margin-bottom: 1rem;
        }
        .error-message {
            font-size: 1rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }
        .error-divider {
            width: 60px;
            height: 3px;
            background: var(--brand-gold);
            margin: 1.5rem auto;
            border-radius: 2px;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            background: var(--brand-gold);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: 0.3s;
            margin: 0.4rem;
        }
        .btn-back:hover {
            background: white;
            color: var(--brand-dark);
            transform: translateY(-2px);
        }
        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            background: transparent;
            color: rgba(255,255,255,0.8);
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border: 1px solid rgba(255,255,255,0.3);
            transition: 0.3s;
            margin: 0.4rem;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-color: rgba(255,255,255,0.6);
        }
        .logo-area {
            margin-bottom: 2rem;
        }
        .logo-area img {
            height: 60px;
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }
        @media (max-width: 480px) {
            .error-code { font-size: 5rem; }
            .error-title { font-size: 1.5rem; }
            .btn-back, .btn-outline { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="logo-area">
            <img src="{{ asset('assets/img/logo-full.webp') }}" alt="Elnair Travel" onerror="this.style.display='none'">
        </div>

        <div class="error-icon">
            @yield('icon')
        </div>

        <div class="error-code">@yield('code')</div>
        <div class="error-divider"></div>
        <h1 class="error-title">@yield('title')</h1>
        <p class="error-message">@yield('message')</p>

        <div>
            <a href="{{ url('/') }}" class="btn-back">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
            <a href="javascript:history.back()" class="btn-outline">
                <i class="fas fa-arrow-left"></i> Halaman Sebelumnya
            </a>
        </div>
    </div>
</body>
</html>
