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

        .register-card {
            max-width: 400px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
            padding: 2rem 3rem 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .register-title {
            font-size: 2rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            color: #222;
            width: 100%;
            text-align: left;
        }

        .register-form-group {
            width: 100%;
            margin-bottom: 1.2rem;
        }

        .register-label {
            display: block;
            font-size: 1rem;
            margin-bottom: 0.3rem;
            color: #333;
        }

        .register-input {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #f7f7f7;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s;
        }

        .register-input:focus {
            border: 1.5px solid #2d3e50;
            background: #fff;
        }

        .register-btn {
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

        .register-btn:hover {
            background: #2d3e50;
        }

        .register-footer {
            margin-top: 1.2rem;
            text-align: center;
            font-size: 0.9rem;
            color: #888;
        }

        .register-footer a {
            color: #2d3e50;
            text-decoration: underline;
        }
    </style>

    <div class="register-card">
        <div class="register-title">Register</div>
        <form method="POST" action="{{ route('register') }}" style="width: 100%;">
            @csrf

            <div class="register-form-group">
                <label for="first_name" class="register-label">{{ __('First Name') }}</label>
                <input id="first_name" class="register-input" type="text" name="first_name"
                    value="{{ old('first_name') }}" required autofocus autocomplete="given-name" />
                <x-input-error :messages="$errors->get('first_name')" />
            </div>

            <div class="register-form-group">
                <label for="middle_name" class="register-label">{{ __('Middle Name') }}</label>
                <input id="middle_name" class="register-input" type="text" name="middle_name"
                    value="{{ old('middle_name') }}" autocomplete="additional-name" />
                <x-input-error :messages="$errors->get('middle_name')" />
            </div>

            <div class="register-form-group">
                <label for="last_name" class="register-label">{{ __('Last Name') }}</label>
                <input id="last_name" class="register-input" type="text" name="last_name"
                    value="{{ old('last_name') }}" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('last_name')" />
            </div>

            <div class="register-form-group">
                <label for="email" class="register-label">{{ __('Email') }}</label>
                <input id="email" class="register-input" type="email" name="email" value="{{ old('email') }}"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="register-form-group">
                <label for="role" class="register-label">{{ __('Register As (to be removed in final)') }}</label>
                <select id="role" class="register-input" name="role" required
                    onchange="toggleUserFields(this.value)">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <x-input-error :messages="$errors->get('role')" />
            </div>

            <div id="user-fields" style="{{ old('role') === 'admin' ? 'display:none;' : '' }}">
                <div class="register-form-group">
                    <label for="grade_level" class="register-label">{{ __('Grade Level') }}</label>
                    <input id="grade_level" class="register-input" type="number" name="grade_level" min="1"
                        max="12" value="{{ old('grade_level') }}" />
                    <x-input-error :messages="$errors->get('grade_level')" />
                </div>

                <div class="register-form-group">
                    <label for="school" class="register-label">{{ __('School') }}</label>
                    <input id="school" class="register-input" type="text" name="school"
                        value="{{ old('school') }}" />
                    <x-input-error :messages="$errors->get('school')" />
                </div>

                <div class="register-form-group">
                    <label for="coach_name" class="register-label">{{ __('Coach Name') }}</label>
                    <input id="coach_name" class="register-input" type="text" name="coach_name"
                        value="{{ old('coach_name') }}" />
                    <x-input-error :messages="$errors->get('coach_name')" />
                </div>
            </div>

            <div class="register-form-group">
                <label for="password" class="register-label">{{ __('Password') }}</label>
                <input id="password" class="register-input" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="register-form-group">
                <label for="password_confirmation" class="register-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="register-input" type="password" name="password_confirmation"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div class="register-footer">
                <a href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <button type="submit" class="register-btn">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleUserFields(role) {
            document.getElementById('user-fields').style.display = (role === 'admin') ? 'none' : '';
        }
    </script>
</x-guest-layout>
