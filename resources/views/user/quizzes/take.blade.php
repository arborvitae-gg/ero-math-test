<x-app-layout>
    <x-slot name="header">
        {{-- Removed extra title --}}
    </x-slot>

    <div x-data="quizHandler()" class="quiz-container">
        {{-- Removed progress bar, question number, and timer above the card --}}
        <div class="question-container">
            {{-- partials/answer-form.blade.php --}}
            @include('user.quizzes.partials.answer-form', [
                'quizUser' => $quizUser,
                'question' => $question,
                'choices' => $choices,
                'quizDuration' => $quizDuration,
                'remainingTime' => $remainingTime ?? null,
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
