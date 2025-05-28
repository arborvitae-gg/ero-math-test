<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Results for: ') }} {{ $quiz->title }}</h2>
    </x-slot>

    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.quizzes.results.index', $quiz) }}">
            &larr; Back to Quizzes</a> {{-- &larr: back arrow --}}
    </div>

    {{-- User Details --}}
    @include('components.quiz-results-details')

</x-app-layout>
