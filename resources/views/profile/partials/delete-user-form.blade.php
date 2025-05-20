<section>
    <style>
        .delete-account-card {
            max-width: 450px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 2rem 2.5rem 1.5rem 2rem;
        }
        .delete-account-card header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #e53935;
            margin-bottom: 0.3rem;
        }
        .delete-account-card header p {
            color: #555;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }
        .delete-account-card form > div {
            margin-bottom: 1.2rem;
        }
        .delete-account-card input[type="password"] {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #f7f7f7;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s;
        }
        .delete-account-card input[type="password"]:focus {
            border: 1.5px solid #e53935;
            background: #fff;
        }
        .delete-account-card button {
            background: #e53935;
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .delete-account-card button:hover {
            background: #b71c1c;
        }
        .delete-account-card .input-error {
            color: #e53935;
            font-size: 0.95rem;
            margin-top: 0.2rem;
        }
        @media (max-width: 600px) {
            .delete-account-card {
                padding: 1rem 0.5rem;
            }
            .delete-account-card header h2 {
                font-size: 1.1rem;
            }
        }
    </style>
    <div class="delete-account-card">
        <header>
            <h2>{{ __('Delete Account') }}</h2>

            <p>
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
            </p>
        </header>

        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div>
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" placeholder="{{ __('Password') }}"/>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="input-error" />
            </div>

            <div>
                <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete your account?') }}')">{{ __('Delete Account') }}</button>
            </div>
        </form>

    </div>
</section>
