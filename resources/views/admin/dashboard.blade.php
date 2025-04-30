<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Admin Dashboard') }}</h2>
    </x-slot>

    <div>
        <p>Welcome, Admin {{ Auth::user()->first_name }}!</p>
        <p>Use the navigation to manage Users and Quizzes.</p>
    </div>
</x-app-layout>
