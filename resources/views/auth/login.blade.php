<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Ero-Math Competition</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f6f8fc 0%, #e9edf5 100%);
            display: flex;
            flex-direction: column;
        }

        header {
            background: linear-gradient(135deg, rgba(0, 0, 139, 0.95), rgba(0, 0, 139, 0.85));
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8px);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .logo img {
            height: 45px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        nav {
            display: flex;
            gap: 1.5rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1.05rem;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            margin-top: 76px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 139, 0.08);
            padding: 2rem;
            padding-right: 3rem;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 48px rgba(0, 0, 139, 0.12);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-logo img {
            height: 50px;
            width: auto;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1a2b3c;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-form-group {
            margin-bottom: 1.25rem;
        }

        .login-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            color: #1a2b3c;
            margin-bottom: 0.5rem;
        }

        .login-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e9edf5;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .login-input:focus {
            outline: none;
            border-color: rgba(0, 0, 139, 0.5);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0, 0, 139, 0.1);
        }

        .login-remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
            margin-top: 0.5rem;
        }

        .login-remember input[type="checkbox"] {
            width: 1.2rem;
            height: 1.2rem;
            border-radius: 4px;
            border: 2px solid #e9edf5;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #000080, #0000b3);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #0000b3, #0000e6);
            transform: translateY(-2px);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
        }

        .login-footer a {
            color: #000080;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #0000b3;
            text-decoration: underline;
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        @media (max-width: 640px) {
            .nav-container {
                padding: 0 1rem;
            }

            .login-container {
                padding: 1rem;
            }

            .login-card {
                padding: 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="{{ asset('images/Erovoutika Light Logo.png') }}" alt="Ero-Math Logo">
            </a>
            <nav>
                <a href="{{ route('register') }}">Register</a>
            </nav>
        </div>
    </header>

    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('images/Erovoutika_logo.png') }}" alt="Erovoutika Logo">
            </div>
            <h1 class="login-title">Welcome Back</h1>

            @if (session('status'))
                <div class="error-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-form-group">
                    <label for="email" class="login-label">Email</label>
                    <input id="email" class="login-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <div class="login-form-group">
                    <label for="password" class="login-label">Password</label>
                    <input id="password" class="login-input" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="error-message" />
                </div>

                <div class="login-remember">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <button type="submit" class="login-btn">
                    Sign in
                </button>

                <div class="login-footer">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                    <p>
                        Don't have an account? 
                        <a href="{{ route('register') }}">Register now</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
