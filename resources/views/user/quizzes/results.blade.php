<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <style>
        .results-container {
            max-width: 1200px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem 2.5rem;
        }

        .question-block {
            margin-bottom: 2.2rem;
            padding-bottom: 1.2rem;
            border-bottom: 1px solid #ececec;
        }

        .question-block:last-child {
            border-bottom: none;
        }

        .question-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a2b3c;
            margin-bottom: 1.5rem;
            line-height: 1.4;
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
            transition: border 0.2s, background 0.2s;
        }

        .choice-item:last-child {
            margin-bottom: 0;
        }

        .choice-content {
            flex: 1;
            font-size: 1.1rem;
            color: #1a2b3c;
        }

        .choice-content img {
            max-width: 120px;
            height: auto;
            border-radius: 8px;
            margin-left: 1rem;
        }

        .choice-label {
            margin-left: 1.2rem;
            min-width: 120px;
            text-align: right;
        }

        .label {
            display: inline-block;
            padding: 0.3em 0.8em;
            border-radius: 16px;
            font-size: 0.95em;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .label-success {
            background: #e6f4ea;
            color: #388e3c;
            border: 1px solid #b2dfdb;
        }

        .label-error {
            background: #fdeaea;
            color: #e53935;
            border: 1px solid #ffcdd2;
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
            padding: 0.5rem 1rem;
            border-radius: 24px;
            font-size: 0.95rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .label svg {
            width: 16px;
            height: 16px;
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
            background: linear-gradient(135deg, #000080, #0000b3);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 2rem auto;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.15);
        }

        .return-link:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #0000b3, #0000e6);
        }

        @media (max-width: 600px) {
            #quiz-results {
                padding: 1rem 0.5rem;
            }

            .choice-content {
                font-size: 0.97rem;
            }
            
            .choice-label {
                margin-left: 0;
            }
        }

        .return-dashboard-link {
            display: inline-block;
            margin: 2rem auto 0 auto;
            background: #2d3e50;
            color: #fff;
            border: none;
            border-radius: 22px;
            padding: 0.7rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        }

        .return-dashboard-link:hover {
            background: #1a2533;
        }

    </style>

    <div class="results-container">
        <div class="results-header">
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
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Correct Answer
                                    </span>
                                @elseif ($isCorrectChoice)
                                    <span class="label label-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Correct Answer
                                    </span>
                                @elseif ($isUserChoice)
                                    <span class="label label-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
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
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Return to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
