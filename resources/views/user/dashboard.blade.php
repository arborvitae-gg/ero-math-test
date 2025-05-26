@extends('layouts.app')

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome, {{ Auth::user()->first_name }}!</h2>
            <p>You can now take quizzes, view your results, and download your certificates once available.</p>
        </div>

        <div class="quiz-grid">
            @forelse($quizzes as $quiz)
                <div class="quiz-card">
                    <h3 class="quiz-title">{{ $quiz->title }}</h3>
                    <p class="quiz-description">{{ $quiz->description }}</p>
                    
                    <div class="quiz-meta">
                        <div class="quiz-meta-item">
                            <span class="quiz-meta-label">Questions</span>
                            <span class="quiz-meta-value">{{ $quiz->questions_count }}</span>
                        </div>
                        <div class="quiz-meta-item">
                            <span class="quiz-meta-label">Time Limit</span>
                            <span class="quiz-meta-value">{{ $quiz->time_limit }} mins</span>
                        </div>
                    </div>

                    @if($quiz->userResult)
                        <div class="quiz-status status-completed">
                            Completed
                        </div>
                        <div class="quiz-score">
                            Score: {{ $quiz->userResult->score }}/{{ $quiz->questions_count }}
                        </div>
                        <div class="quiz-actions">
                            <a href="{{ route('user.quizzes.attempts.results', [$quiz, $quiz->userResult]) }}" class="quiz-btn view-results">
                                View Results
                            </a>
                        </div>
                    @elseif($quiz->userProgress)
                        <div class="quiz-status status-in-progress">
                            In Progress
                        </div>
                        <div class="quiz-actions">
                            <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}">
                                @csrf
                                <button type="submit" class="quiz-btn continue">Continue Quiz</button>
                            </form>
                        </div>
                    @else
                        <div class="quiz-status waiting">
                            Not Started
                        </div>
                        <div class="quiz-actions">
                            <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}">
                                @csrf
                                <button type="submit" class="quiz-btn start">Start Quiz</button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="no-quizzes">
                    <p>No quizzes available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
