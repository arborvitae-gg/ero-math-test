<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Results for: ') }} {{ $quiz->title }}</h2>
    </x-slot>

    {{-- Back Button --}}
    <div>
        <a href="{{ route('user.dashboard') }}">
            &larr; Back to Dashboard</a> {{-- &larr: back arrow --}}
    </div>

    {{-- User Details --}}
    @include('components.quiz-results-details', ['hideUser' => true])


</x-app-layout>
