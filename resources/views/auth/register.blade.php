<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="register-card">

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
                <label for="email" class="register-label">Email</label>
                <input id="email" class="register-input" type="email" name="email" value="{{ old('email') }}"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="error-message" />
            </div>

            {{-- for testing, to be removed --}}
            <div class="register-form-group">
                <label for="role" class="register-label">For Testing: Register As</label>
                <select id="role" class="register-input" name="role" required
                    onchange="toggleUserFields(this.value)">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Student</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="error-message" />
            </div>

            {{-- only appears for users, disappears for admin --}}
            <div id="user-fields" style="{{ old('role') === 'admin' ? 'display:none;' : '' }}">
                <div class="form-grid">
                    <div class="register-form-group">
                        <label for="grade_level" class="register-label">Grade Level</label>
                        <select id="grade_level" class="register-input" name="grade_level" required>
                            <option value="">Select Grade Level</option>
                            <option value="3" {{ old('grade_level') == 3 ? 'selected' : '' }}>Grade 3 (Category
                                1)</option>
                            <option value="4" {{ old('grade_level') == 4 ? 'selected' : '' }}>Grade 4 (Category
                                1)</option>
                            <option value="5" {{ old('grade_level') == 5 ? 'selected' : '' }}>Grade 5 (Category
                                2)</option>
                            <option value="6" {{ old('grade_level') == 6 ? 'selected' : '' }}>Grade 6 (Category
                                2)</option>
                            <option value="7" {{ old('grade_level') == 7 ? 'selected' : '' }}>Grade 7 (Category
                                3)</option>
                            <option value="8" {{ old('grade_level') == 8 ? 'selected' : '' }}>Grade 8 (Category
                                3)</option>
                            <option value="9" {{ old('grade_level') == 9 ? 'selected' : '' }}>Grade 9 (Category
                                4)</option>
                            <option value="10" {{ old('grade_level') == 10 ? 'selected' : '' }}>Grade 10 (Category
                                4)</option>
                            <option value="11" {{ old('grade_level') == 11 ? 'selected' : '' }}>Grade 11 (Category
                                5)</option>
                            <option value="12" {{ old('grade_level') == 12 ? 'selected' : '' }}>Grade 12 (Category
                                5)</option>
                        </select>
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
                <a href="{{ route('login') }}">
                    Already have an account? Sign in
                </a>
            </div>

        </div>
    </form>

    {{-- for the toggleable fields if admin is selected --}}
    <script>
        function toggleUserFields(role) {
            const userFields = document.getElementById('user-fields');
            userFields.style.display = role === 'admin' ? 'none' : 'block';
        }
    </script>

</x-guest-layout>
