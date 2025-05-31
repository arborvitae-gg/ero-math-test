<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">{{ __('User Dashboard') }}</h2>
    </x-slot>

    <div class="dashboard-card">
        <div class="dashboard-welcome">
            Welcome, {{ Auth::user()->first_name }}!<br>
            <span style="font-size: 1rem; color: #888;">You can now take quizzes, view your results, and download your certificates once available.</span>
        </div>
        <div class="dashboard-actions">
            <a href="{{ route('user.dashboard') }}" class="dashboard-btn">View Available Quizzes</a>
            <a href="#" class="dashboard-btn secondary">View Results</a>
            <a href="#" class="dashboard-btn secondary">Download Certificates</a>
        </div>
    </div>
</x-app-layout>
