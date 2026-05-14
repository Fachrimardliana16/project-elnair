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
    </style>
</head>
<body>

    <div class="login-card">
        <h1>Elnair Admin</h1>
        <p>Enter your credentials to access the portal</p>

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@mail.com" required>
                @error('email') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                @error('password') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn-login">Sign In</button>
        </form>
    </div>

</body>
</html>
