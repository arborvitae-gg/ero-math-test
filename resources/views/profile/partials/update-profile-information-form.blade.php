<section>
    <header>
        <h2>{{ __('Profile Information') }}</h2>
        <p>{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        {{-- First Name --}}
        <div>
            <label for="first_name">{{ __('First Name') }}</label>
            <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}"
                required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" />
        </div>

        {{-- Middle Name --}}
        <div>
            <label for="middle_name">{{ __('Middle Name') }}</label>
            <input id="middle_name" name="middle_name" type="text"
                value="{{ old('middle_name', $user->middle_name) }}" autocomplete="additional-name" />
            <x-input-error :messages="$errors->get('middle_name')" />
        </div>

        {{-- Last Name --}}
        <div>
            <label for="last_name">{{ __('Last Name') }}</label>
            <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}"
                required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p>
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p>{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save Button --}}
        <div>
            <button>{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p>{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
