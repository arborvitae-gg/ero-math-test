<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
            <label for="first_name">{{ __('First Name') }}</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" />
        </div>

        <!-- Middle Name -->
        <div>
            <label for="middle_name">{{ __('Middle Name') }}</label>
            <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}"
                autocomplete="additional-name" />
            <x-input-error :messages="$errors->get('middle_name')" />
        </div>

        <!-- Last Name -->
        <div>
            <label for="last_name">{{ __('Last Name') }}</label>
            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Role -->
        <div>
            <label for="role">{{ __('Register As') }}</label>
            <select id="role" name="role" required onchange="toggleUserFields(this.value)">
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" />
        </div>

        <!-- Grade Level (for users only) -->
        <div id="user-fields" style="{{ old('role') === 'admin' ? 'display:none;' : '' }}">
            <div>
                <label for="grade_level">{{ __('Grade Level') }}</label>
                <input id="grade_level" type="number" name="grade_level" min="1" max="12"
                    value="{{ old('grade_level') }}" />
                <x-input-error :messages="$errors->get('grade_level')" />
            </div>

            <!-- School -->
            <div>
                <label for="school">{{ __('School') }}</label>
                <input id="school" type="text" name="school" value="{{ old('school') }}" />
                <x-input-error :messages="$errors->get('school')" />
            </div>

            <!-- Coach Name -->
            <div>
                <label for="coach_name">{{ __('Coach Name') }}</label>
                <input id="coach_name" type="text" name="coach_name" value="{{ old('coach_name') }}" />
                <x-input-error :messages="$errors->get('coach_name')" />
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <!-- Submit -->
        <div>
            <a href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit">
                {{ __('Register') }}
            </button>
        </div>
    </form>

    <script>
        function toggleUserFields(role) {
            document.getElementById('user-fields').style.display = (role === 'admin') ? 'none' : '';
        }
    </script>
</x-guest-layout>
