<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Elnair Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-dark: #0D4C54;
            --brand-gold: #8B5E3C;
            --brand-beige: #DCD0C0;
            --sidebar-width: 260px;
            --header-height: 70px;
            --bg-light: #f8f9fa;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background: var(--bg-light); color: #333; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--brand-dark);
            position: fixed;
            left: 0; top: 0;
            color: white;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo {
            height: 50px;
            width: auto;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
            list-style: none;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 1rem 2rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.3s;
        }

        .sidebar-menu li a i {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-menu li a:hover, .sidebar-menu li.active a {
            background: rgba(255,255,255,0.05);
            color: var(--brand-gold);
            border-left: 4px solid var(--brand-gold);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        header {
            height: var(--header-height);
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .header-title h2 {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-logout {
            background: none;
            border: none;
            color: #888;
            cursor: pointer;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-logout:hover { color: var(--brand-dark); }

        .content-body {
            padding: 2rem;
        }

        /* Cards & UI */
        .admin-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 25px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
        }

        .btn-admin {
            background: var(--brand-dark);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-admin:hover {
            background: var(--brand-gold);
        }

        .btn-admin-outline {
            background: transparent;
            border: 1px solid var(--brand-dark);
            color: var(--brand-dark);
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-admin-outline:hover {
            background: var(--brand-dark);
            color: white;
        }

        /* Form Controls */
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; }
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
        }
        .form-control:focus { outline: none; border-color: var(--brand-gold); }

        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; padding: 1rem; border-bottom: 2px solid #eee; font-size: 0.9rem; color: #888; }
        td { padding: 1rem; border-bottom: 1px solid #eee; font-size: 0.95rem; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h3 style="font-family: 'Playfair Display', serif; color: var(--brand-gold);">ELNAIR</h3>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a>
            </li>
            <li class="{{ Request::is('admin/hero') ? 'active' : '' }}">
                <a href="{{ route('admin.hero') }}"><i class="fas fa-desktop"></i> Hero Content</a>
            </li>
            <li class="{{ Request::is('admin/features*') ? 'active' : '' }}">
                <a href="{{ route('admin.features.index') }}"><i class="fas fa-star"></i> Why Choose Us</a>
            </li>
            <li class="{{ Request::is('admin/packages*') ? 'active' : '' }}">
                <a href="{{ route('admin.packages.index') }}"><i class="fas fa-kaaba"></i> Packages</a>
            </li>
            <li class="{{ Request::is('admin/testimonials*') ? 'active' : '' }}">
                <a href="{{ route('admin.testimonials.index') }}"><i class="fas fa-comment-dots"></i> Testimonials</a>
            </li>
            <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                <a href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i> Website Settings</a>
            </li>
            <li>
                <a href="/" target="_blank"><i class="fas fa-external-link-alt"></i> View Website</a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <div class="header-title">
                <h2>@yield('page_title', 'Dashboard')</h2>
            </div>
            <div class="user-menu">
                <span style="font-size: 0.9rem; font-weight: 600;">{{ Auth::user()->name }}</span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </header>

        <div class="content-body">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>
