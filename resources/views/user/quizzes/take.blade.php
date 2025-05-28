<x-app-layout>
    <x-slot name="header">
        <h2>{{ $quizUser->quiz->title }}</h2>
    </x-slot>

    <div x-data="quizHandler()" class="quiz-container">

        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>

        <h3>
            Question {{ $quizUser->current_question }} of {{ count($quizUser->question_order) }}
        </h3>

        @if ($quizDuration !== null)
            <div class="timer-container">
                <span id="quiz-timer" class="quiz-timer"></span>
            </div>
        @endif

        <div class="question-container">
            {{-- partials/answer-form.blade.php --}}
            @include('user.quizzes.partials.answer-form', [
                'quizUser' => $quizUser,
                'question' => $question,
                'choices' => $choices,
            ])
        </div>

        @if ($quizDuration !== null)
            <form id="auto-submit-form" action="{{ route('user.quizzes.attempts.submit', [$quiz, $quizUser]) }}"
                method="POST">
                @csrf
            </form>
        @endif
    </div>

    @if ($quizDuration !== null)
        <script>
            window.quizRemainingTime = {{ $remainingTime ?? 0 }};
            window.quizSubmitUrl = @json(route('user.quizzes.attempts.submit', [$quiz, $quizUser]));
        </script>
    @endif
</x-app-layout>
