<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <style>
        .quiz-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .quiz-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .quiz-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a2b3c;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .quiz-header p {
            font-size: 1.1rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }

        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .quiz-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .quiz-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(0, 0, 139, 0.12);
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

        .quiz-meta-item {
            background: #f8fafc;
            padding: 0.75rem;
            border-radius: 12px;
            text-align: center;
        }

        .quiz-meta-label {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .quiz-meta-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a2b3c;
        }

        .quiz-status {
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
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #000080, #0000b3);
            color: #fff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0000b3, #0000e6);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f8fafc;
            color: #1a2b3c;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .quiz-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .quiz-header h2 {
                font-size: 2rem;
            }

            .quiz-card {
                padding: 1.5rem;
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
                        <div class="quiz-status status-completed">Completed</div>
                        @if ($quizUser->can_view_score)
                            <div class="quiz-score">Score: {{ $quizUser->total_score }}</div>
                            <div class="quiz-actions">
                                <a href="{{ route('user.quizzes.attempts.results', [$quiz, $quizUser]) }}" class="quiz-btn btn-secondary">View Results</a>
                            </div>
                        @else
                            <div class="quiz-status status-waiting">Waiting for results...</div>
                        @endif
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
