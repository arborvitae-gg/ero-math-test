<section>
    <style>
        .profile-info-card {
            max-width: 450px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 2rem 2.5rem 1.5rem 2rem;
        }
        .profile-info-card header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 0.3rem;
        }
        .profile-info-card header p {
            color: #555;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }
        .profile-info-card form > div {
            margin-bottom: 1.2rem;
        }
        .profile-info-card label {
            display: block;
            font-size: 1rem;
            margin-bottom: 0.3rem;
            color: #333;
        }
        .profile-info-card input[type="text"],
        .profile-info-card input[type="email"] {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #f7f7f7;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s;
        }
        .profile-info-card input[type="text"]:focus,
        .profile-info-card input[type="email"]:focus {
            border: 1.5px solid #2d3e50;
            background: #fff;
        }
        .profile-info-card button {
            background: #222;
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .profile-info-card button:hover {
            background: #2d3e50;
        }
        .profile-info-card .input-error {
            color: #e53935;
            font-size: 0.95rem;
            margin-top: 0.2rem;
        }
        .profile-info-card .verified-message,
        .profile-info-card .status-message {
            color: #388e3c;
            font-size: 0.98rem;
            margin-top: 0.5rem;
        }
        @media (max-width: 600px) {
            .profile-info-card {
                padding: 1rem 0.5rem;
            }
            .profile-info-card header h2 {
                font-size: 1.1rem;
            }
        }
    </style>
    <div class="profile-info-card">
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
                <x-input-error :messages="$errors->get('first_name')" class="input-error" />
            </div>

            {{-- Middle Name --}}
            <div>
                <label for="middle_name">{{ __('Middle Name') }}</label>
                <input id="middle_name" name="middle_name" type="text"
                    value="{{ old('middle_name', $user->middle_name) }}" autocomplete="additional-name" />
                <x-input-error :messages="$errors->get('middle_name')" class="input-error" />
            </div>

            {{-- Last Name --}}
            <div>
                <label for="last_name">{{ __('Last Name') }}</label>
                <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}"
                    required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('last_name')" class="input-error" />
            </div>

            {{-- Email --}}
            <div>
                <label for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="input-error" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="verified-message">
                        <p>
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" type="submit">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="status-message">{{ __('A new verification link has been sent to your email address.') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Save Button --}}
            <div>
                <button type="submit">{{ __('Save') }}</button>

                @if (session('status') === 'profile-updated')
                    <p class="status-message">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>
</section>
