@extends('layouts.app')

@pushOnce('styles')
    @vite(['resources/css/quiz.css'])
@endPushOnce

@section('content')
<div class="quiz-container">
    <div class="quiz-header">
        <h1>Available Quizzes</h1>
        <p>Challenge yourself with our math quizzes designed for your grade level. Track your progress and improve your skills.</p>
    </div>

    <div class="quiz-grid">
        @foreach ($quizzes as $quiz)
            @php
                $quizUser = $quizUsers[$quiz->id] ?? null;
                $questionsInCategory = $quiz->questions->where('category_id', auth()->user()->category->id)->count();
            @endphp

            <div class="quiz-card">
                <h2 class="quiz-title">{{ $quiz->title }}</h2>
                
                <div class="quiz-meta">
                    <div class="quiz-meta-item">
                        <span class="quiz-meta-label">Timer</span>
                        <span class="quiz-meta-value">{{ $quiz->timer ? $quiz->timer . 's' : 'No Timer' }}</span>
                    </div>
                    <div class="quiz-meta-item">
                        <span class="quiz-meta-label">Questions</span>
                        <span class="quiz-meta-value">{{ $questionsInCategory }}</span>
                    </div>
                </div>

                <div class="quiz-status-container">
                    @if (!$quizUser)
                        <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}" class="quiz-actions">
                            @csrf
                            <button type="submit" class="quiz-btn start">Start Quiz</button>
                        </form>
                    @elseif ($quizUser->status === 'completed')
                        <div class="quiz-status status-completed">Completed</div>
                        @if ($quizUser->can_view_score)
                            <div class="quiz-score">Score: {{ $quizUser->total_score }}</div>
                            <div class="quiz-actions">
                                <a href="{{ route('user.quizzes.attempts.results', [$quiz, $quizUser]) }}" class="quiz-btn view-results">View Results</a>
                            </div>
                        @else
                            <div class="quiz-status status-waiting">Waiting for results...</div>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
:root {
    --primary-dark: rgb(30, 27, 75);
    --primary-light: rgb(59, 54, 140);
    --background: rgb(230, 230, 255);
    --card-bg: rgb(252, 252, 255);
    --meta-bg: rgb(246, 246, 255);
    --text-primary: rgb(30, 27, 75);
    --text-secondary: rgb(87, 83, 130);
    --success-bg: rgb(220, 252, 231);
    --success-text: rgb(22, 101, 52);
    --waiting-bg: rgb(224, 231, 255);
    --waiting-text: rgb(40, 70, 199);
}

body {
    background-color: var(--background);
    margin: 0;
    min-height: 100vh;
    font-family: system-ui, -apple-system, sans-serif;
}

.quiz-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 12px rgba(30, 27, 75, 0.07);
}

.quiz-header {
    text-align: center;
    margin-bottom: 2rem;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
    padding: 2rem;
    border-radius: 1rem;
    color: white;
    box-shadow: 0 4px 20px rgba(30, 27, 75, 0.15);
}

.quiz-header h1 {
    font-size: 2.25rem;
    margin: 0 0 1rem 0;
    font-weight: 600;
    color: white;
}

.quiz-header p {
    font-size: 1rem;
    margin: 0;
    opacity: 0.9;
    line-height: 1.5;
    color: white;
}

.quiz-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.quiz-card {
    background: var(--card-bg);
    border-radius: 1rem;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 12px rgba(30, 27, 75, 0.07);
    border: 1px solid rgba(30, 27, 75, 0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.quiz-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(30, 27, 75, 0.1);
}

.quiz-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 2rem 0;
}

.quiz-meta {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

.quiz-meta-item {
    background: var(--meta-bg);
    padding: 1rem;
    border-radius: 0.5rem;
    text-align: center;
    transition: background-color 0.2s ease;
}

.quiz-meta-item:hover {
    background: rgb(241, 241, 255);
}

.quiz-meta-label {
    display: block;
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
}

.quiz-meta-value {
    font-weight: 600;
    color: var(--text-primary);
}

.quiz-status-container {
    margin-top: auto;
}

.quiz-status {
    text-align: center;
    padding: 0.75rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.status-completed {
    background: var(--success-bg);
    color: var(--success-text);
}

.status-waiting {
    background: var(--waiting-bg);
    color: var(--waiting-text);
}

.quiz-score {
    text-align: center;
    font-size: 1rem;
    color: var(--success-text);
    margin-bottom: 1rem;
    font-weight: 600;
}

.quiz-actions {
    margin-top: auto;
}

.quiz-btn {
    display: inline-block;
    width: 100%;
    padding: 0.75rem;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
    color: white;
    transition: all 0.2s ease;
}

.quiz-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 27, 75, 0.2);
}

@media (max-width: 1200px) {
    .quiz-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .quiz-container {
        padding: 1rem;
        margin: 1rem auto;
    }

    .quiz-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .quiz-header {
        padding: 1.5rem;
    }

    .quiz-header h1 {
        font-size: 1.75rem;
    }

    .quiz-card {
        padding: 1.5rem;
    }
}
</style>
@endsection
