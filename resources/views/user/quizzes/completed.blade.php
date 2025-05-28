<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz Completed') }}</h2>
    </x-slot>

    <div>
        <div>
            <h3>Congratulations!</h3>
            <p>
                You have successfully completed:
                <span>{{ $quizUser->quiz->title }}</span>
            </p>
        </div>

        <div>
            <a href="{{ route('user.dashboard') }}">
                Back to Dashboard
            </a>
            <a href="{{ route('user.quizzes.attempts.results', [$quizUser->quiz, $quizUser]) }}">
                View Results
            </a>
        </div>
    </div>

</x-app-layout>
