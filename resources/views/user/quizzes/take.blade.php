<x-app-layout>
    <x-slot name="header">
        <h2 class="quiz-title">{{ $quizUser->quiz->title }}</h2>
    </x-slot>


    <style>
        .quiz-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .quiz-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a2b3c;
            text-align: center;
        }

        .progress-bar {
            background: #f1f5f9;
            height: 8px;
            border-radius: 4px;
            margin: 2rem 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #000080, #0000b3);
            width: calc(({{ $quizUser->current_question }} / {{ count($quizUser->question_order) }}) * 100%);
            transition: width 0.3s ease;
        }

        .progress-text {
            text-align: center;
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .question-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .question-text {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1a2b3c;
            margin-bottom: 1.5rem;
            line-height: 1.4;
        }

        .question-image {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .choices-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .choice-item {
            position: relative;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .choice-item:hover {
            border-color: #000080;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 139, 0.08);
        }

        .choice-label {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .choice-radio {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .choice-radio:checked+.choice-label {
            background: rgba(0, 0, 128, 0.05);
            border-color: #000080;
        }

        .choice-radio:checked+.choice-label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #000080;
        }

        .choice-text {
            flex: 1;
            font-size: 1.1rem;
            color: #1a2b3c;
            margin-left: 1rem;
        }

        .choice-image {
            max-width: 120px;
            height: auto;
            border-radius: 8px;
            margin-left: 1rem;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            gap: 1rem;
        }

        .nav-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: linear-gradient(135deg, #000080, #0000b3);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-button:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #0000b3, #0000e6);
        }

        .nav-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .submit-button {
            background: linear-gradient(135deg, #059669, #047857);
        }

        .submit-button:hover {
            background: linear-gradient(135deg, #047857, #065f46);
        }

        @media (max-width: 768px) {
            .quiz-container {
                margin: 1rem auto;
            }

            .question-container {
                padding: 1.5rem;
            }

            .question-text {
                font-size: 1.2rem;
            }

            .choice-label {
                padding: 0.75rem 1rem;
            }

            .navigation {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div x-data="quizHandler()" class="quiz-container">

        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>

        <div class="progress-text">
            Question {{ $quizUser->current_question }} of {{ count($quizUser->question_order) }}
        </div>

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
                method="POST" style="display:none;">
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
