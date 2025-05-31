<x-app-layout>
    <x-slot name="header">
        {{-- Removed extra title --}}
    </x-slot>

    <div x-data="quizHandler()" class="quiz-container">
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('quiz-taking');
    });
    </script>
    <style>
    body.quiz-taking nav.navbar, body.quiz-taking .navbar, body.quiz-taking .navbar-container {
        display: none !important;
    }
    body.quiz-taking {
        background: #f8fafc !important;
        overflow: hidden !important;
    }
    .quiz-container {
        height: 100vh;
        overflow-y: auto;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 20px;
    }
    .question-container {
        max-width: 100%;
        padding: 20px;
    }
    .quiz-attempt-choices {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    </style>
</x-app-layout>
