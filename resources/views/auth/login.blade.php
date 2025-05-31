<x-guest-layout>
    <div class="login-links">
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    </div>

    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Please sign in to continue</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Remember me</label>
            </div>

            <button type="submit">Sign in</button>

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
</x-guest-layout>
