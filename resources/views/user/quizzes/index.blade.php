<x-app-layout>
    <x-slot name="header">
    </x-slot>

    @php
        $userCategory = \App\Models\Category::findCategoryForGrade($user->grade_level);
    @endphp

    <div class="quiz-container">
        <div class="quiz-header">
            <h2>Available Quizzes</h2>
            <p>Challenge yourself with our math quizzes designed for your grade level. Track your progress and improve
                your skills.</p>
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
                            <a href="{{ route('user.quizzes.attempts.show', [$quiz, $quizUser]) }}"
                                class="quiz-btn btn-primary">Continue Quiz</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
