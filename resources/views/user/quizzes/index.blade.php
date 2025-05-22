<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Available Quizzes') }}</h2>
    </x-slot>

    <style>
        .quiz-list-container {
            max-width: 700px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem 2.5rem;
        }

        .quiz-item {
            padding: 1.5rem 0 1rem 0;
            border-bottom: 1px solid #ececec;
        }

        .quiz-item:last-child {
            border-bottom: none;
        }

        .quiz-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 0.3rem;
        }

        .quiz-meta {
            color: #555;
            font-size: 1rem;
            margin-bottom: 0.7rem;
        }

        .quiz-actions {
            margin-top: 0.7rem;
        }

        .quiz-actions button,
        .quiz-actions a {
            display: inline-block;
            background: #2d3e50;
            color: #fff;
            border: none;
            border-radius: 22px;
            padding: 0.6rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            margin-right: 0.5rem;
            margin-bottom: 0.3rem;
            text-decoration: none;
            transition: background 0.2s, box-shadow 0.2s;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        }

        .quiz-actions button:hover,
        .quiz-actions a:hover {
            background: #1a2533;
        }

        .quiz-status {
            font-size: 1rem;
            color: #388e3c;
            font-weight: 500;
            margin-bottom: 0.2rem;
        }

        .quiz-score {
            font-size: 1rem;
            color: #1976d2;
            font-weight: 500;
            margin-bottom: 0.2rem;
        }

        .quiz-waiting {
            font-size: 1rem;
            color: #e53935;
            font-weight: 500;
            margin-bottom: 0.2rem;
        }

        @media (max-width: 600px) {
            .quiz-list-container {
                padding: 1rem 0.5rem;
            }

            .quiz-title {
                font-size: 1.05rem;
            }
        }
    </style>

    @php
        $userCategory = \App\Models\Category::findCategoryForGrade($user->grade_level);
    @endphp

    <div class="quiz-list-container">
        @foreach ($quizzes as $quiz)
            @php
                $quizUser = $quizUsers[$quiz->id] ?? null;
                $questionsInCategory = $quiz->questions->where('category_id', $userCategory?->id)->count();
            @endphp

            <div class="quiz-item">
                <div class="quiz-title">{{ $quiz->title }}</div>
                <div class="quiz-meta">
                    Timer: {{ $quiz->timer ? $quiz->timer . ' seconds' : 'No Timer' }}<br>
                    Questions available: {{ $questionsInCategory }}
                </div>

                <div class="quiz-actions">
                    @if (!$quizUser)
                        <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}" style="display:inline;">
                            @csrf
                            <button type="submit">Start Quiz</button>
                        </form>
                    @elseif ($quizUser->status === 'completed')
                        <div class="quiz-status">Completed</div>
                        @if ($quizUser->can_view_score)
                            <div class="quiz-score">Your Score: {{ $quizUser->total_score }} /
                                {{ $questionsInCategory }}</div>
                            <a href="{{ route('user.quizzes.attempts.results', [$quiz, $quizUser]) }}">View Results</a>
                        @else
                            <div class="quiz-waiting">Waiting for results...</div>
                        @endif
                        {{-- <a href="{{ route('user.quizzes.certificate', [$quiz, $quizUser]) }}">Download Certificate</a> --}}
                    @else
                        <a href="{{ route('user.quizzes.attempts.show', [$quiz, $quizUser]) }}">Continue Quiz</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
