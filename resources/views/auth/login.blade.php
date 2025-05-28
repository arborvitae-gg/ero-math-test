<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="login-card">

            @if (session('status'))
                <div class="error-message">
                    {{ session('status') }}
                </div>
            @endif

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
                    </a><br>
                @endif

                <a href="{{ route('register') }}">
                    Don't have an account? Register now
                </a>
            </div>

        </div>
    </form>
</x-guest-layout>
