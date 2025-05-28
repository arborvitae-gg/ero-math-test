@vite(['resources/css/app.css'])

<section>
    <div class="form-header">
        <p>Update your account's profile information and email address.</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-grid">
            <div class="form-group">
                <label for="first_name" class="form-label">First Name</label>
                <input id="first_name" name="first_name" type="text" class="form-input"
                    value="{{ old('first_name', $user->first_name) }}" required autofocus autocomplete="given-name" />
                <x-input-error :messages="$errors->get('first_name')" class="form-error" />
            </div>

            <div class="form-group">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input id="middle_name" name="middle_name" type="text" class="form-input"
                    value="{{ old('middle_name', $user->middle_name) }}" autocomplete="additional-name" />
                <x-input-error :messages="$errors->get('middle_name')" class="form-error" />
            </div>
        </div>

        <div class="form-group">
            <label for="last_name" class="form-label">Last Name</label>
            <input id="last_name" name="last_name" type="text" class="form-input"
                value="{{ old('last_name', $user->last_name) }}" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" class="form-error" />
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-input"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="form-error" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="form-error">
                    Your email address is unverified.
                    <button form="send-verification" class="btn btn-secondary">
                        Click here to re-send the verification email
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="form-success">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        A new verification link has been sent to your email address.
                    </div>
                @endif
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <div class="form-success">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                </div>
            @endif
        </div>
    </form>
</section>
