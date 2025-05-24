<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz Results') }}</h2>
    </x-slot>

    <style>
        #quiz-results {
            max-width: 700px;
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
            font-size: 1.15rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 1.1rem;
        }

        .choices-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .choice-item {
            margin-bottom: 0.7rem;
            padding: 0.9rem 1.2rem;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            background: #f7f7f7;
            display: flex;
            align-items: center;
            transition: border 0.2s, background 0.2s;
        }

        .choice-item:last-child {
            margin-bottom: 0;
        }

        .choice-content {
            flex: 1;
            font-size: 1rem;
            color: #222;
            word-break: break-word;
        }

        .choice-content img {
            max-width: 120px;
            max-height: 60px;
            object-fit: contain;
            border-radius: 4px;
            background: #fff;
            border: 1px solid #e0e0e0;
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
            border: 2px solid #388e3c;
            background: #e6f4ea;
        }

        .choice-correct {
            border: 2px solid #1976d2;
            background: #e3f2fd;
        }

        .choice-wrong-user {
            border: 2px solid #e53935;
            background: #fdeaea;
        }

        .choice-default {
            border: 2px solid #e0e0e0;
            background: #f7f7f7;
        }

        @media (max-width: 600px) {
            #quiz-results {
                padding: 1rem 0.5rem;
            }

            .choice-content {
                font-size: 0.97rem;
            }

            .choice-label {
                min-width: 80px;
                margin-left: 0.5rem;
                font-size: 0.9em;
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

    <div id="quiz-results">
        @foreach ($quizUser->attempts as $attempt)
            @php
                $question = $attempt->question;
            @endphp

            <div class="question-block" id="question-{{ $question->id }}">
                <h3>{{ $question->question_text }}</h3>

                @if (!empty($question->question_image))
                    <img src="{{ $question->question_image_url }}" alt="Question Image">
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

                        <li class="choice-item {{ $choiceClass }}" data-choice-id="{{ $choice->id }}">
                            <div class="choice-content">
                                {{ $choice->choice_text }}
                                @if (!empty($choice->choice_image))
                                    <img src="{{ $choice->choice_image_url }}" alt="Choice Image">
                                @endif
                            </div>

                            <div class="choice-label">
                                @if ($isCorrectChoice && $isUserChoice)
                                    <span class="label label-success">✔ Your answer is correct</span>
                                @elseif ($isCorrectChoice)
                                    <span class="label label-success">✔ Correct answer</span>
                                @elseif ($isUserChoice)
                                    <span class="label label-error">✖ Your answer</span>
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
    </div>

    <div style="text-align:center;">
        <a href="{{ route('user.dashboard') }}" class="return-dashboard-link">Return to Dashboard</a>
    </div>
</x-app-layout>
