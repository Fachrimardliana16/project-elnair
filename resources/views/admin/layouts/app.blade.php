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
            overflow-y: auto;
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--brand-gold);
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

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Mobile Responsive Adjustments */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--brand-dark);
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .menu-toggle { display: block; }
            
            .sidebar {
                left: calc(var(--sidebar-width) * -1);
            }

            .sidebar.active {
                left: 0;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .main-content {
                margin-left: 0 !important;
            }

            header {
                padding: 0 1rem;
            }

            .content-body {
                padding: 1rem;
            }

            .admin-card {
                padding: 1.2rem;
            }

            .header-title h2 {
                font-size: 1rem;
            }

            .user-menu span {
                display: none;
            }
        }

        /* iPhone SE Specific Fixes */
        @media (max-width: 375px) {
            .sidebar-header img {
                width: 140px !important;
            }
            .btn-admin {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header" style="padding: 2rem 1.2rem; text-align: center;">
            <div style="background: white; border-radius: 12px; height: 90px; width: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                <img src="{{ asset('assets/img/logo-full.png') }}" alt="Logo" style="width: 170px; height: auto; flex-shrink: 0; margin-top: 40px;">
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a>
            </li>
            
            @can('manage_hero')
            <li class="{{ Request::is('admin/hero') ? 'active' : '' }}">
                <a href="{{ route('admin.hero') }}"><i class="fas fa-desktop"></i> Hero Content</a>
            </li>
            @endcan

            @can('manage_features')
            <li class="{{ Request::is('admin/features*') ? 'active' : '' }}">
                <a href="{{ route('admin.features.index') }}"><i class="fas fa-star"></i> Why Choose Us</a>
            </li>
            @endcan

            @can('manage_packages')
            <li class="{{ Request::is('admin/packages*') ? 'active' : '' }}">
                <a href="{{ route('admin.packages.index') }}"><i class="fas fa-kaaba"></i> Packages</a>
            </li>
            @endcan

            @can('manage_testimonials')
            <li class="{{ Request::is('admin/testimonials*') ? 'active' : '' }}">
                <a href="{{ route('admin.testimonials.index') }}"><i class="fas fa-comment-dots"></i> Testimonials</a>
            </li>
            @endcan
            
            @if(auth()->user()->canAny(['manage_users', 'manage_roles', 'manage_gallery', 'manage_articles', 'manage_ads', 'manage_landing_pages', 'view_logs']))
            <li class="menu-divider" style="padding: 1rem 2rem 0.5rem; font-size: 0.7rem; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 1px;">Management</li>
            @endif
            
            @can('manage_users')
            <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Users</a>
            </li>
            @endcan

            @can('manage_roles')
            <li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
                <a href="{{ route('admin.roles.index') }}"><i class="fas fa-user-shield"></i> Roles & Permissions</a>
            </li>
            @endcan

            @can('manage_gallery')
            <li class="{{ Request::is('admin/gallery*') ? 'active' : '' }}">
                <a href="{{ route('admin.gallery.index') }}"><i class="fas fa-images"></i> Gallery</a>
            </li>
            @endcan

            @can('manage_articles')
            <li class="{{ Request::is('admin/articles*') ? 'active' : '' }}">
                <a href="{{ route('admin.articles.index') }}"><i class="fas fa-newspaper"></i> Articles</a>
            </li>
            @endcan

            @can('manage_ads')
            <li class="{{ Request::is('admin/ads*') ? 'active' : '' }}">
                <a href="{{ route('admin.ads.index') }}"><i class="fas fa-ad"></i> Marketing Ads</a>
            </li>
            @endcan

            @can('manage_landing_pages')
            <li class="{{ Request::is('admin/landing-pages*') ? 'active' : '' }}">
                <a href="{{ route('admin.landing-pages.index') }}"><i class="fas fa-pager"></i> Landing Pages</a>
            </li>
            @endcan

            @can('view_logs')
            <li class="{{ Request::is('admin/logs*') ? 'active' : '' }}">
                <a href="{{ route('admin.logs') }}"><i class="fas fa-exclamation-triangle"></i> Error Logs</a>
            </li>
            @endcan

            @can('manage_settings')
            <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                <a href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i> Website Settings</a>
            </li>
            @endcan

            <li>
                <a href="/" target="_blank"><i class="fas fa-external-link-alt"></i> View Website</a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-title">
                    <h2>@yield('page_title', 'Dashboard')</h2>
                </div>
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
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Success Notifications
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#0D4C54',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Error Notifications
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#0D4C54'
            });
        @endif

        // Validation Errors
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<ul style="text-align: left; font-size: 0.9rem; color: #666;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#0D4C54'
            });
        @endif

        // Global Delete Confirmation
        document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
            form.removeAttribute('onsubmit');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0D4C54',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Sidebar Toggle Logic
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if(menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });
        }

        if(overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }
    </script>

</body>
</html>
