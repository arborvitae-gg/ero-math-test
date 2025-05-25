<section>
    <style>
        .form-header {
            margin-bottom: 2rem;
        }

        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a2b3c;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.5;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            color: #1a2b3c;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: .7rem .2rem .7rem .2rem;
            border: 2px solid #e9edf5;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(0, 0, 139, 0.5);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0, 0, 139, 0.1);
        }

        .form-error {
            color: #dc2626;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: #fee2e2;
            border-radius: 8px;
        }

        .form-success {
            color: #059669;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: #dcfce7;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-success svg {
            width: 16px;
            height: 16px;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #000080, #0000b3);
            color: #fff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0000b3, #0000e6);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f8fafc;
            color: #1a2b3c;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

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
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
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
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Saved successfully
                </div>
            @endif
        </div>
    </form>
</section>
