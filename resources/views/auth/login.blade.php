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

    <!-- Refactor login form markup to use .form-group, .form-label, .form-input, .form-error, .btn, etc. for unified styling. -->
    <div class="login-container">
        <div class="profile-section" style="max-width: 400px; margin: 3rem auto;">
            <div class="login-logo" style="text-align:center; margin-bottom:1.5rem;">
                <img src="{{ asset('images/Erovoutika_logo.png') }}" alt="Erovoutika Logo"
                    style="height:50px; width:auto;">
            </div>
            <h1 class="login-title"
                style="text-align:center; font-size:1.5rem; font-weight:600; color:#1a2b3c; margin-bottom:1.5rem;">
                Welcome Back</h1>
            @if (session('status'))
                <div class="form-error">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="form-error" />
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="form-error" />
                </div>
                <div class="form-group" style="display:flex; align-items:center; gap:0.5rem;">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
                <div class="form-actions"
                    style="flex-direction:column; align-items:flex-start; gap:0.5rem; margin-top:1rem;">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                    <p>Don't have an account? <a href="{{ route('register') }}">Register now</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
