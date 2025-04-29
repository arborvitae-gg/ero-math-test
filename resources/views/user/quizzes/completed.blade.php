<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz Completed') }}</h2>
    </x-slot>

    <div>
        <p>Thank you for completing the quiz!</p>

        <a href="{{ route('user.dashboard') }}">Return to Dashboard</a>
    </div>
</x-app-layout>
