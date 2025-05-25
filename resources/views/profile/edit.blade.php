<x-app-layout>
    <x-slot name="header">
      
    </x-slot>

    <style>
        .profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .profile-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a2b3c;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-header p {
            font-size: 1.1rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .profile-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #000080, #0000b3);
        }

        .danger-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(255, 0, 0, 0.08);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .danger-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }

        @media (max-width: 1024px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .profile-container {
                margin: 1rem auto;
            }

            .profile-header h2 {
                font-size: 2rem;
            }

            .profile-section,
            .danger-section {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="profile-container">
        <div class="profile-header">
            <h2>Profile Settings</h2>
            <p>Manage your account settings and preferences</p>
        </div>

        <div class="profile-grid">
            <div>
                <div class="profile-section">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="profile-section">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div>
                <div class="danger-section">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
