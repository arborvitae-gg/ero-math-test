<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Ero-Math Competition</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f6f8fc 0%, #e9edf5 100%);
            display: flex;
            flex-direction: column;
        }

        header {
            background: linear-gradient(135deg, rgba(0, 0, 139, 0.95), rgba(0, 0, 139, 0.85));
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8px);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .logo img {
            height: 45px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        nav {
            display: flex;
            gap: 1.5rem;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1.05rem;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .register-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            margin-top: 76px;
        }

        .register-card {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 139, 0.08);
            padding: 3rem;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 48px rgba(0, 0, 139, 0.12);
        }

        .register-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .register-logo img {
            height: 50px;
            width: auto;
        }

        .register-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1a2b3c;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .register-form-group {
            margin-bottom: 1.25rem;
        }

        .register-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            color: #1a2b3c;
            margin-bottom: 0.5rem;
        }

        .register-input {
            width: 100%;
            padding: 5px;
            border: 2px solid #e9edf5;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .register-input:focus {
            outline: none;
            border-color: rgba(0, 0, 139, 0.5);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0, 0, 139, 0.1);
        }

        .register-btn {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #000080, #0000b3);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .register-btn:hover {
            background: linear-gradient(135deg, #0000b3, #0000e6);
            transform: translateY(-2px);
        }

        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
        }

        .register-footer a {
            color: #000080;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register-footer a:hover {
            color: #0000b3;
            text-decoration: underline;
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-top: 0.5rem;
            font-size: 0.95rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 0.25rem;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
        }

        @media (max-width: 640px) {
            .nav-container {
                padding: 0 1rem;
            }

            .register-container {
                padding: 1rem;
            }

            .register-card {
                padding: 1.5rem;
            }

            .register-title {
                font-size: 1.5rem;
            }

            .register-form-group {
                margin-bottom: 1rem;
            }
        }
    </style>
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
                        <input id="first_name" class="register-input" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name" />
                        <x-input-error :messages="$errors->get('first_name')" class="error-message" />
                    </div>

                    <div class="register-form-group">
                        <label for="middle_name" class="register-label">Middle Name</label>
                        <input id="middle_name" class="register-input" type="text" name="middle_name" value="{{ old('middle_name') }}" autocomplete="additional-name" />
                        <x-input-error :messages="$errors->get('middle_name')" class="error-message" />
                    </div>
                </div>

                <div class="register-form-group">
                    <label for="last_name" class="register-label">Last Name</label>
                    <input id="last_name" class="register-input" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" />
                    <x-input-error :messages="$errors->get('last_name')" class="error-message" />
                </div>

                <div class="register-form-group">
                    <label for="email" class="register-label">Email</label>
                    <input id="email" class="register-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <div class="register-form-group">
                    <label for="role" class="register-label">Register As</label>
                    <select id="role" class="register-input" name="role" required onchange="toggleUserFields(this.value)">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Student</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="error-message" />
                </div>

                <div id="user-fields" style="{{ old('role') === 'admin' ? 'display:none;' : '' }}">
                    <div class="form-grid">
                        <div class="register-form-group">
                            <label for="grade_level" class="register-label">Grade Level</label>
                            <input id="grade_level" class="register-input" type="number" name="grade_level" min="1" max="12" value="{{ old('grade_level') }}" />
                            <x-input-error :messages="$errors->get('grade_level')" class="error-message" />
                        </div>

                        <div class="register-form-group">
                            <label for="school" class="register-label">School</label>
                            <input id="school" class="register-input" type="text" name="school" value="{{ old('school') }}" />
                            <x-input-error :messages="$errors->get('school')" class="error-message" />
                        </div>
                    </div>

                    <div class="register-form-group">
                        <label for="coach_name" class="register-label">Coach Name</label>
                        <input id="coach_name" class="register-input" type="text" name="coach_name" value="{{ old('coach_name') }}" />
                        <x-input-error :messages="$errors->get('coach_name')" class="error-message" />
                    </div>
                </div>

                <div class="form-grid">
                    <div class="register-form-group">
                        <label for="password" class="register-label">Password</label>
                        <input id="password" class="register-input" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="error-message" />
                    </div>

                    <div class="register-form-group">
                        <label for="password_confirmation" class="register-label">Confirm Password</label>
                        <input id="password_confirmation" class="register-input" type="password" name="password_confirmation" required autocomplete="new-password" />
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
