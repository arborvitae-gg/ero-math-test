<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('User Dashboard') }}</h2>
    </x-slot>

    <div>
        <p>Welcome, {{ Auth::user()->first_name }}!</p>

        <p>You can now take quizzes, view your results, and download your certificates once available.</p>

        <div>
            <a href="{{ route('user.dashboard') }}">View Available Quizzes</a>
        </div>
    </div>
</x-app-layout>
