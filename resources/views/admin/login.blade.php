<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Elnair Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #0D4C54;
            --brand-gold: #8B5E3C;
            --brand-beige: #DCD0C0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--brand-dark);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            width: 100%;
            max-width: 400px;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
        }
        .login-card h1 {
            font-family: 'Playfair Display', serif;
            color: var(--brand-dark);
            margin-bottom: 0.5rem;
        }
        .login-card p {
            color: #888;
            margin-bottom: 2.5rem;
            font-size: 0.9rem;
        }
        .form-group { text-align: left; margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.85rem; color: #555; }
        .form-control {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-family: inherit;
            transition: 0.3s;
        }
        .form-control:focus { outline: none; border-color: var(--brand-gold); }
        .btn-login {
            width: 100%;
            padding: 1rem;
            background: var(--brand-dark);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 1rem;
        }
        .btn-login:hover { background: var(--brand-gold); }
        .error-msg { color: #dc3545; font-size: 0.8rem; margin-top: 0.5rem; }

        /* Custom Modal */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            backdrop-filter: blur(5px);
        }
        .modal-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            transform: translateY(20px);
            transition: 0.3s;
        }
        .modal-overlay.active { display: flex; }
        .modal-overlay.active .modal-card { transform: translateY(0); }
        .modal-card i {
            font-size: 3rem;
            color: var(--brand-gold);
            margin-bottom: 1.5rem;
        }
        .modal-card h2 {
            color: var(--brand-dark);
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
        }
        .modal-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="login-card" style="padding-top: 3rem;">
        <div style="overflow: hidden; height: 110px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem; padding-top: 10px;">
            <img src="{{ asset('assets/img/logo-full.png') }}" alt="Elnair Logo" style="width: 200px; height: auto; transform: scale(1.0); transform-origin: center;">
        </div>
        <p style="margin-bottom: 2rem;">Access the administrative dashboard</p>

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@mail.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">Sign In</button>
            <div style="margin-top: 1.5rem;">
                <a href="javascript:void(0)" onclick="toggleModal(true)" style="color: #888; text-decoration: none; font-size: 0.85rem;">Forgot Password?</a>
            </div>
        </form>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" class="modal-overlay" onclick="toggleModal(false)">
        <div class="modal-card" onclick="event.stopPropagation()">
            <i class="fas fa-shield-alt"></i>
            <h2>Security Notice</h2>
            <p>For your security, password resets must be authorized by a system administrator. Please contact your IT department or manager to regain access.</p>
            <button onclick="toggleModal(false)" class="btn-login" style="margin-top: 0;">I Understand</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleModal(show) {
            const modal = document.getElementById('forgotPasswordModal');
            if (show) {
                modal.classList.add('active');
            } else {
                modal.classList.remove('active');
            }
        }

        // Show Errors if any
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: "{{ $errors->first() }}",
                confirmButtonColor: '#0D4C54'
            });
        @endif
    </script>

</body>
</html>
