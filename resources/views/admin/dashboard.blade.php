<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-dashboard-title">{{ __('Admin Dashboard') }}</h2>
    </x-slot>

    <div class="admin-dashboard-card">
        <div class="admin-dashboard-welcome">
            Welcome, Admin {{ Auth::user()->first_name }}!
        </div>
        <div class="admin-dashboard-info">
            Use the navigation to manage Users and Quizzes.
        </div>
    </div>
</x-app-layout>
