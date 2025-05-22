<section>
    <style>
        .update-password-card {
            max-width: 450px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 2rem 2.5rem 1.5rem 2rem;
        }
        .update-password-card header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 0.3rem;
        }
        .update-password-card header p {
            color: #555;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }
        .update-password-card form > div {
            margin-bottom: 1.2rem;
        }
        .update-password-card label {
            display: block;
            font-size: 1rem;
            margin-bottom: 0.3rem;
            color: #333;
        }
        .update-password-card input[type="password"] {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #f7f7f7;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s;
        }
        .update-password-card input[type="password"]:focus {
            border: 1.5px solid #2d3e50;
            background: #fff;
        }
        .update-password-card button {
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
        .update-password-card button:hover {
            background: #2d3e50;
        }
        .update-password-card .input-error {
            color: #e53935;
            font-size: 0.95rem;
            margin-top: 0.2rem;
        }
        .update-password-card .status-message {
            color: #388e3c;
            font-size: 0.98rem;
            margin-top: 0.5rem;
        }
        @media (max-width: 600px) {
            .update-password-card {
                padding: 1rem 0.5rem;
            }
            .update-password-card header h2 {
                font-size: 1.1rem;
            }
        }
    </style>
    <div class="update-password-card">
        <header>
            <h2>{{ __('Update Password') }}</h2>
            <p>
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div>
                <label for="update_password_current_password">{{__('Current Password')}}</label>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="input-error" />
            </div>

            <div>
                <label for="update_password_password">{{__('New Password')}}</label>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="input-error" />
            </div>

            <div>
                <label for="update_password_password_confirmation">{{__('Confirm Password')}}</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="input-error" />
            </div>

            <div>
                <button type="submit">{{ __('Save') }}</button>

                @if (session('status') === 'password-updated')
                    <p class="status-message">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>
</section>
