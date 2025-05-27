<x-app-layout>
    <x-slot name="header">

    </x-slot>
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
