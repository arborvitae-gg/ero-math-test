<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz Completed') }}</h2>
    </x-slot>

    <div class="quiz-completed">
        <p>You have completed the quiz: <strong>{{ $quizUser->quiz->title }}</strong></p>

        <div class="actions">
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
            {{-- <a href="{{ route('user.quizzes.attempts.results', [$quizUser->quiz, $quizUser]) }}"
                class="btn btn-secondary">View
                Results</a> --}}
            {{-- <a href="{{ route('user.quizzes.certificate', [$quizUser->quiz, $quizUser]) }}"
                class="btn btn-success">Download Certificate</a> --}}
        </div>

    </div>
</x-app-layout>
