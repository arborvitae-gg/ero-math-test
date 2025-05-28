<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <style>
        .results-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .results-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, #000080, #0000b3);
            border-radius: 24px;
            color: white;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.15);
        }

        .results-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .results-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .results-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin: 2rem auto;
            max-width: 800px;
        }

        .summary-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
            transition: transform 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1a2b3c;
            margin-bottom: 0.5rem;
        }

        .summary-label {
            color: #64748b;
            font-size: 0.95rem;
        }

        .question-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }

        .question-container:hover {
            transform: translateY(-5px);
        }

        .question-text {
            font-size: 1.25rem;
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
        }

        .choices-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .choice-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .choice-content {
            flex: 1;
            font-size: 1.1rem;
            color: #1a2b3c;
        }

        .choice-image {
            max-width: 120px;
            height: auto;
            border-radius: 8px;
            margin-left: 1rem;
        }

        .choice-label {
            margin-left: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .choice-correct-user {
            background: #dcfce7;
            border-color: #166534;
        }

        .choice-correct {
            background: #dbeafe;
            border-color: #1e40af;
        }

        .choice-wrong-user {
            background: #fee2e2;
            border-color: #991b1b;
        }

        .choice-default {
            background: #f8fafc;
            border-color: #e2e8f0;
        }

        .label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
        }

        .label svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .label-success {
            background: #dcfce7;
            color: #166534;
        }

        .label-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .return-link {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #000080, #0000b3);
            color: white;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 2rem;
        }

        .return-link:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #0000b3, #0000e6);
        }

        @media (max-width: 768px) {
            .results-container {
                padding: 1rem;
            }

            .results-header {
                padding: 1.5rem;
                margin-bottom: 2rem;
            }

            .results-header h2 {
                font-size: 2rem;
            }

            .results-summary {
                grid-template-columns: 1fr;
            }

            .question-container {
                padding: 1.5rem;
            }

            .choice-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .choice-label {
                margin: 1rem 0 0 0;
            }
        }
    </style>

    <div class="results-container">
        <div class="results-header">
            <h2 class="quiz-title">{{ $quizUser->quiz->title }} - Results</h2>
            <h2>Quiz Results</h2>
            <p>Review your answers and see how well you did!</p>
        </div>

        <div class="results-summary">
            <div class="summary-card">
                <div class="summary-value">{{ $quizUser->total_score }}%</div>
                <div class="summary-label">Overall Score</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ $quizUser->attempts->where('is_correct', true)->count() }}</div>
                <div class="summary-label">Correct Answers</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ $quizUser->attempts->count() }}</div>
                <div class="summary-label">Total Questions</div>
            </div>
        </div>

        @foreach ($quizUser->attempts as $attempt)
            @php
                $question = $attempt->question;
            @endphp

            <div class="question-container">
                <div class="question-text">{{ $question->question_text }}</div>

                @if (!empty($question->question_image))
                    <img src="{{ $question->question_image_url }}" alt="Question Image" class="question-image">
                @endif

                <ul class="choices-list">
                    @php
                        $userAnswered = $attempt->choice !== null;
                    @endphp
                    @foreach ($question->choices as $choice)
                        @php
                            $isUserChoice = $attempt->choice && $attempt->choice->id === $choice->id;
                            $isCorrectChoice = $choice->is_correct;

                            if ($isCorrectChoice && $isUserChoice) {
                                $choiceClass = 'choice-correct-user';
                            } elseif ($isCorrectChoice) {
                                $choiceClass = 'choice-correct';
                            } elseif ($isUserChoice) {
                                $choiceClass = 'choice-wrong-user';
                            } else {
                                $choiceClass = 'choice-default';
                            }
                        @endphp

                        <li class="choice-item {{ $choiceClass }}">
                            <div class="choice-content">
                                {{ $choice->choice_text }}
                                @if (!empty($choice->choice_image))
                                    <img src="{{ $choice->choice_image_url }}" alt="Choice Image" class="choice-image">
                                @endif
                            </div>

                            <div class="choice-label">
                                @if ($isCorrectChoice && $isUserChoice)
                                    <span class="label label-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Correct Answer
                                    </span>
                                @elseif ($isCorrectChoice)
                                    <span class="label label-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Correct Answer
                                    </span>
                                @elseif ($isUserChoice)
                                    <span class="label label-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Your Answer
                                    </span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                    @if (!$userAnswered)
                        <li class="choice-item choice-default">
                            <div class="choice-content" style="font-style:italic; color:#888;">
                                (You skipped this question)
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        @endforeach

        <div style="text-align: center;">
            <a href="{{ route('user.dashboard') }}" class="return-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    style="width: 20px; height: 20px;">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Return to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
