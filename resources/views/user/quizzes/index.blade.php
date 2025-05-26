<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <style>
        .quiz-container {
            max-width: 1200px;
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
            font-size: 1.4rem;
            font-weight: 600;
            color: #1a2b3c;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .quiz-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .quiz-actions {
            margin-top: 0.7rem;
        }

        .quiz-actions button,
        .quiz-actions a {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 24px;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-in-progress {
            background: #fff7ed;
            color: #9a3412;
        }

        .status-waiting {
            background: #fef2f2;
            color: #991b1b;
        }

        .quiz-score {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a2b3c;
            margin-bottom: 1rem;
            text-align: center;
        }

        .quiz-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .quiz-btn {
            flex: 1;
            min-width: 120px;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
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
                font-size: 1.25rem;
            }

            .quiz-meta {
                gap: 0.75rem;
            }

            .quiz-meta-item {
                padding: 0.5rem;
            }
        }
    </style>

    @php
        $userCategory = \App\Models\Category::findCategoryForGrade($user->grade_level);
    @endphp

    <div class="quiz-container">
        <div class="quiz-header">
            <h2>Available Quizzes</h2>
            <p>Challenge yourself with our math quizzes designed for your grade level. Track your progress and improve your skills.</p>
        </div>

        <div class="quiz-grid">
            @foreach ($quizzes as $quiz)
                @php
                    $quizUser = $quizUsers[$quiz->id] ?? null;
                    $questionsInCategory = $quiz->questions->where('category_id', $userCategory?->id)->count();
                @endphp

                <div class="quiz-card">
                    <h3 class="quiz-title">{{ $quiz->title }}</h3>
                    
                    <div class="quiz-meta">
                        <div class="quiz-meta-item">
                            <div class="quiz-meta-label">Timer</div>
                            <div class="quiz-meta-value">{{ $quiz->timer ? $quiz->timer . 's' : 'No Timer' }}</div>
                        </div>
                        <div class="quiz-meta-item">
                            <div class="quiz-meta-label">Questions</div>
                            <div class="quiz-meta-value">{{ $questionsInCategory }}</div>
                        </div>
                    </div>

                    @if (!$quizUser)
                        <div class="quiz-actions">
                            <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}" style="width: 100%;">
                                @csrf
                                <button type="submit" class="quiz-btn btn-primary">Start Quiz</button>
                            </form>
                        </div>
                    @elseif ($quizUser->status === 'completed')

                        <div class="quiz-status">Completed</div>

                        <div class="quiz-score">Your Score: {{ $quizUser->total_score }} /
                            {{ $questionsInCategory }}</div>
                        <a href="{{ route('user.quizzes.attempts.results', [$quiz, $quizUser]) }}">View Results</a>

                        {{-- <a href="{{ route('user.quizzes.certificate', [$quiz, $quizUser]) }}">Download Certificate</a> --}}
                    @else
                        <div class="quiz-status status-in-progress">In Progress</div>
                        <div class="quiz-actions">
                            <a href="{{ route('user.quizzes.attempts.show', [$quiz, $quizUser]) }}" class="quiz-btn btn-primary">Continue Quiz</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
