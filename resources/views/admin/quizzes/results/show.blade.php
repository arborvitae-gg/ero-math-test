<x-app-layout>
    <x-slot name="header">
        <div class="results-header-center">
            <h2>{{ __('Results for: ') }} {{ $quiz->title }}</h2>
        </div>
    </x-slot>

    <div class="results-back-link-container">
        <a href="{{ route('admin.quizzes.results.index', $quiz) }}" class="results-back-link">&larr; Back to Quizzes</a>
    </div>

    <div class="quiz-results-card">
        {{-- User Details and Questions --}}
        @include('components.quiz-results-details')
    </div>
</x-app-layout>
