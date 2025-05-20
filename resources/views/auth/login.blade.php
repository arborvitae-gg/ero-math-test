<x-guest-layout>
    <x-slot name="logo">
        <a href="/">
            <img src="{{ asset('images/Erovoutika_logo.png') }}" alt="Erovoutika Logo" style="height: 60px;">
        </a>
    </x-slot>

    <style>
        header {
            background: darkblue;
            padding: 1rem 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .logo img {
            height: 40px;
            width: auto;
            display: block;
            padding-left: 20px;
        }

        nav {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background 0.2s;
        }

        nav a:hover {
            background: #1a2533;
        }

        .login-card {
            max-width: 350px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
            padding: 2rem 2rem 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-logo img {
            max-width: 200px;
            margin-bottom: 1.5rem;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            color: #222;
            width: 100%;
            text-align: left;
        }

        .login-form-group {
            width: 100%;
            margin-bottom: 1.2rem;
        }

        .login-label {
            display: block;
            font-size: 1rem;
            margin-bottom: 0.3rem;
            color: #333;
        }

        .login-input-wrapper {
            position: relative;
        }

        .login-input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 1rem;
        }

        .login-input {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #f7f7f7;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s;
        }

        .login-input:focus {
            border: 1.5px solid #2d3e50;
            background: #fff;
        }

        .login-remember {
            display: flex;
            align-items: center;
            margin-bottom: 1.2rem;
            width: 100%;
        }

        .login-remember input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .login-actions {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.2rem;
        }

        .login-actions a {
            font-size: 0.95rem;
            color: #2d3e50;
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            background: #222;
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 0.9rem 0;
            font-size: 1.1rem;
            font-weight: 500;
            margin-top: 0.5rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .login-btn:hover {
            background: #2d3e50;
        }

        .login-footer {
            margin-top: 1.2rem;
            text-align: center;
            font-size: 0.9rem;
            color: #888;
        }

        .login-footer a {
            color: #2d3e50;
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .nav-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            nav {
                flex-direction: column;
                align-items: flex-end;
                gap: 0.5rem;
            }
        }
    </style>

    <div class="login-card">
        <div class="login-logo">
            <img src="{{ asset('images/Erovoutika_logo.png') }}" alt="Erovoutika Logo">
        </div>
        <div class="login-title">Log in</div>
        @if (session('status'))
            <div style="color: #e53935; margin-bottom: 1rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" style="width: 100%;">
            @csrf

            <div class="login-form-group">
                <label for="email" class="login-label">{{ __('Email') }}</label>
                <div class="login-input-wrapper">
                    <!-- Removed icon -->
                    <input id="email" class="login-input" type="email" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="login-form-group">
                <label for="password" class="login-label">{{ __('Password') }}</label>
                <div class="login-input-wrapper">
                    <!-- Removed icon -->
                    <input id="password" class="login-input" type="password" name="password" required
                        autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="login-remember">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me" style="margin: 0;">{{ __('Remember me') }}</label>
            </div>

            <div class="login-actions">
                <a href="{{ route('register') }}">
                    {{ __('No account yet? Register here') }}
                </a>
            </div>

            <div class="login-actions">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <button type="submit" class="login-btn">{{ __('Log in') }}</button>
        </form>

        <div class="login-footer">
            By signing up you accept our
            <a href="#">Term of Use</a>
            and
            <a href="#">Policies</a>
        </div>
    </div>
</x-guest-layout>
