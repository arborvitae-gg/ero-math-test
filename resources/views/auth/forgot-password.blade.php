<x-guest-layout>

    <div class="forgot-card">
        <div class="forgot-title">Forgot Password</div>
        <div class="forgot-desc">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="forgot-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" style="width: 100%;">
            @csrf

            <div class="forgot-form-group">
                <label for="email" class="forgot-label">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" class="forgot-input" value="{{ old('email') }}"
                    required autofocus />
                <x-input-error :messages="$errors->get('email')" class="" />
            </div>

            <button type="submit" class="forgot-btn">{{ __('Email Password Reset Link') }}</button>
        </form>
    </div>
</x-guest-layout>
