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
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input id="first_name" class="form-input" type="text" name="first_name"
                            value="{{ old('first_name') }}" required autofocus autocomplete="given-name" />
                        <x-input-error :messages="$errors->get('first_name')" class="form-error" />
                    </div>
                    <div class="form-group">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input id="middle_name" class="form-input" type="text" name="middle_name"
                            value="{{ old('middle_name') }}" autocomplete="additional-name" />
                        <x-input-error :messages="$errors->get('middle_name')" class="form-error" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input id="last_name" class="form-input" type="text" name="last_name"
                        value="{{ old('last_name') }}" required autocomplete="family-name" />
                    <x-input-error :messages="$errors->get('last_name')" class="form-error" />
                </div>

                <div class="form-group">
                    <label for="grade_level" class="form-label">{{ __('Grade Level (1-12)') }}</label>
                    <input id="grade_level" class="form-input" type="number" name="grade_level" min="1"
                        max="12" value="{{ old('grade_level') }}" />
                    <x-input-error :messages="$errors->get('grade_level')" class="form-error" />
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}"
                        required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="form-error" />
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Register As</label>
                    <select id="role" class="form-input" name="role" required
                        onchange="toggleUserFields(this.value)">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Student</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="form-error" />
                </div>

                <div id="user-fields" style="{{ old('role') === 'admin' ? 'display:none;' : '' }}">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="grade_level" class="form-label">Grade Level</label>
                            <input id="grade_level" class="form-input" type="number" name="grade_level" min="1"
                                max="12" value="{{ old('grade_level') }}" />
                            <x-input-error :messages="$errors->get('grade_level')" class="form-error" />
                        </div>

                        <div class="form-group">
                            <label for="school" class="form-label">School</label>
                            <input id="school" class="form-input" type="text" name="school"
                                value="{{ old('school') }}" />
                            <x-input-error :messages="$errors->get('school')" class="form-error" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="coach_name" class="form-label">Coach Name</label>
                        <input id="coach_name" class="form-input" type="text" name="coach_name"
                            value="{{ old('coach_name') }}" />
                        <x-input-error :messages="$errors->get('coach_name')" class="form-error" />
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" class="form-input" type="password" name="password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="form-error" />
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" class="form-input" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="form-error" />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Create Account
                </button>

                <div class="form-actions"
                    style="flex-direction:column; align-items:flex-start; gap:0.5rem; margin-top:1rem;">
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
