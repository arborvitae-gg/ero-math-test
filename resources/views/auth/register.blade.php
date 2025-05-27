<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Ero-Math Competition</title>
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
                <a href="{{ route('login') }}">Sign in</a>
            </nav>
        </div>
    </header>

    <div class="register-container">
        <div class="register-card">
            <div class="register-logo">
                <img src="{{ asset('images/Erovoutika_logo.png') }}" alt="Erovoutika Logo">
            </div>
            <h1 class="register-title">Create Account</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-grid">
                    <div class="register-form-group">
                        <label for="first_name" class="register-label">First Name</label>
                        <input id="first_name" class="register-input" type="text" name="first_name"
                            value="{{ old('first_name') }}" required autofocus autocomplete="given-name" />
                        <x-input-error :messages="$errors->get('first_name')" class="error-message" />
                    </div>

                    <div class="register-form-group">
                        <label for="middle_name" class="register-label">Middle Name</label>
                        <input id="middle_name" class="register-input" type="text" name="middle_name"
                            value="{{ old('middle_name') }}" autocomplete="additional-name" />
                        <x-input-error :messages="$errors->get('middle_name')" class="error-message" />
                    </div>
                </div>

                <div class="register-form-group">
                    <label for="last_name" class="register-label">Last Name</label>
                    <input id="last_name" class="register-input" type="text" name="last_name"
                        value="{{ old('last_name') }}" required autocomplete="family-name" />
                    <x-input-error :messages="$errors->get('last_name')" class="error-message" />
                </div>

                <div class="register-form-group">
                    <label for="grade_level" class="register-label">{{ __('Grade Level (1-12)') }}</label>
                    <input id="grade_level" class="register-input" type="number" name="grade_level" min="1"
                        max="12" value="{{ old('grade_level') }}" />
                    <x-input-error :messages="$errors->get('grade_level')" />
                </div>

                <div class="register-form-group">
                    <label for="email" class="register-label">Email</label>
                    <input id="email" class="register-input" type="email" name="email"
                        value="{{ old('email') }}" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <div class="register-form-group">
                    <label for="role" class="register-label">Register As</label>
                    <select id="role" class="register-input" name="role" required
                        onchange="toggleUserFields(this.value)">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Student</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="error-message" />
                </div>

                <div id="user-fields" style="{{ old('role') === 'admin' ? 'display:none;' : '' }}">
                    <div class="form-grid">
                        <div class="register-form-group">
                            <label for="grade_level" class="register-label">Grade Level</label>
                            <input id="grade_level" class="register-input" type="number" name="grade_level"
                                min="1" max="12" value="{{ old('grade_level') }}" />
                            <x-input-error :messages="$errors->get('grade_level')" class="error-message" />
                        </div>

                        <div class="register-form-group">
                            <label for="school" class="register-label">School</label>
                            <input id="school" class="register-input" type="text" name="school"
                                value="{{ old('school') }}" />
                            <x-input-error :messages="$errors->get('school')" class="error-message" />
                        </div>
                    </div>

                    <div class="register-form-group">
                        <label for="coach_name" class="register-label">Coach Name</label>
                        <input id="coach_name" class="register-input" type="text" name="coach_name"
                            value="{{ old('coach_name') }}" />
                        <x-input-error :messages="$errors->get('coach_name')" class="error-message" />
                    </div>
                </div>

                <div class="form-grid">
                    <div class="register-form-group">
                        <label for="password" class="register-label">Password</label>
                        <input id="password" class="register-input" type="password" name="password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="error-message" />
                    </div>

                    <div class="register-form-group">
                        <label for="password_confirmation" class="register-label">Confirm Password</label>
                        <input id="password_confirmation" class="register-input" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="error-message" />
                    </div>
                </div>

                <button type="submit" class="register-btn">
                    Create Account
                </button>

                <div class="register-footer">
                    <p>
                        Already have an account?
                        <a href="{{ route('login') }}">Sign in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleUserFields(role) {
            const userFields = document.getElementById('user-fields');
            userFields.style.display = role === 'admin' ? 'none' : 'block';
        }
    </script>
</body>

</html>
