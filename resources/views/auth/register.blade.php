<x-guest-layout>
    <div class="login-container">
        <div class="login-header">
            <h1>Create Account</h1>
            <p>Please fill in the form to register</p>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <label for="first_name">First Name</label>
                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
            <div>
                <label for="middle_name">Middle Name</label>
                <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}" autocomplete="additional-name" />
                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
            </div>
            <div>
                <label for="last_name">Last Name</label>
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <label for="role">For Testing: Register As</label>
                <select id="role" name="role" required onchange="toggleUserFields(this.value)">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Student</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
            <div id="user-fields" style="{{ old('role') === 'admin' ? 'display:none;' : '' }}">
                <div>
                    <label for="grade_level">Grade Level</label>
                    <select id="grade_level" name="grade_level" required>
                        <option value="">Select Grade Level</option>
                        <option value="3" {{ old('grade_level') == 3 ? 'selected' : '' }}>Grade 3 (Category 1)</option>
                        <option value="4" {{ old('grade_level') == 4 ? 'selected' : '' }}>Grade 4 (Category 1)</option>
                        <option value="5" {{ old('grade_level') == 5 ? 'selected' : '' }}>Grade 5 (Category 2)</option>
                        <option value="6" {{ old('grade_level') == 6 ? 'selected' : '' }}>Grade 6 (Category 2)</option>
                        <option value="7" {{ old('grade_level') == 7 ? 'selected' : '' }}>Grade 7 (Category 3)</option>
                        <option value="8" {{ old('grade_level') == 8 ? 'selected' : '' }}>Grade 8 (Category 3)</option>
                        <option value="9" {{ old('grade_level') == 9 ? 'selected' : '' }}>Grade 9 (Category 4)</option>
                        <option value="10" {{ old('grade_level') == 10 ? 'selected' : '' }}>Grade 10 (Category 4)</option>
                        <option value="11" {{ old('grade_level') == 11 ? 'selected' : '' }}>Grade 11 (Category 5)</option>
                        <option value="12" {{ old('grade_level') == 12 ? 'selected' : '' }}>Grade 12 (Category 5)</option>
                    </select>
                    <x-input-error :messages="$errors->get('grade_level')" class="mt-2" />
                </div>
                <div>
                    <label for="school">School</label>
                    <input id="school" type="text" name="school" value="{{ old('school') }}" />
                    <x-input-error :messages="$errors->get('school')" class="mt-2" />
                </div>
                <div>
                    <label for="coach_name">Coach Name</label>
                    <input id="coach_name" type="text" name="coach_name" value="{{ old('coach_name') }}" />
                    <x-input-error :messages="$errors->get('coach_name')" class="mt-2" />
                </div>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <button type="submit">Create Account</button>
            <div class="login-footer">
                <a href="{{ route('login') }}">
                    Already have an account? Sign in
                </a>
            </div>
        </form>
    </div>
    <script>
        function toggleUserFields(role) {
            const userFields = document.getElementById('user-fields');
            userFields.style.display = role === 'admin' ? 'none' : 'block';
        }
    </script>
</x-guest-layout>
