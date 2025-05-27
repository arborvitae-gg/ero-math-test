<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Ero-Math Competition</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
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
                    <input id="email" class="login-input" type="email" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <div class="login-form-group">
                    <label for="password" class="login-label">Password</label>
                    <input id="password" class="login-input" type="password" name="password" required
                        autocomplete="current-password" />
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
