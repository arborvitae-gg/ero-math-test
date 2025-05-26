<x-guest-layout>
    <style>
        .verify-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .verify-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
            padding: 3rem 2rem;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .verify-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #000080, #0000b3);
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .verify-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a2b3c;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .verify-text {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 400px;
            margin: 0 auto;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 1rem;
        }

        .primary-button {
            background: linear-gradient(135deg, #000080, #0000b3);
            color: white;
        }

        .primary-button:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #0000b3, #0000e6);
        }

        .secondary-button {
            background: #f1f5f9;
            color: #1a2b3c;
        }

        .secondary-button:hover {
            transform: translateY(-2px);
            background: #e2e8f0;
        }

        @media (max-width: 768px) {
            .verify-container {
                margin: 1rem auto;
                padding: 1.5rem 1rem;
            }

            .verify-card {
                padding: 2rem 1.5rem;
            }

            .verify-title {
                font-size: 1.75rem;
            }

            .verify-text {
                font-size: 1rem;
            }
        }
    </style>

    <div class="verify-container">
        <div class="verify-card">
            <div class="verify-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" style="width: 64px; height: 64px;">
                    <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                    <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                </svg>
            </div>

            <h1 class="verify-title">Verify Your Email</h1>
            
            <p class="verify-text">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="success-message">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="actions">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="action-button primary-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 20px; height: 20px;">
                            <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                        </svg>
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="action-button secondary-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 20px; height: 20px;">
                            <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm5.03 4.72a.75.75 0 010 1.06l-1.72 1.72h10.94a.75.75 0 010 1.5H10.81l1.72 1.72a.75.75 0 11-1.06 1.06l-3-3a.75.75 0 010-1.06l3-3a.75.75 0 011.06 0z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
