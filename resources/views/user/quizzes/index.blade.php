<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">{{ __('Quiz List') }}</h2>
    </x-slot>

    @php
        $userCategory = \App\Models\Category::findCategoryForGrade($user->grade_level);
        $showCompleted = request('show_completed', '0') === '1';
    @endphp

    <div class="quiz-list-container">
        <div style="display: flex; gap: 1rem; margin-bottom: 2rem; justify-content: center;">
            <form method="GET">
                <input type="hidden" name="show_completed" value="0">
                <button type="submit" class="dashboard-btn secondary{{ !$showCompleted ? ' active' : '' }}">Ongoing/Not Taken</button>
            </form>
            <form method="GET">
                <input type="hidden" name="show_completed" value="1">
                <button type="submit" class="dashboard-btn secondary{{ $showCompleted ? ' active' : '' }}">Completed</button>
            </form>
        </div>

        @foreach ($quizzes as $quiz)
            @php
                $quizUser = $quizUsers[$quiz->id] ?? null;
                $questionsInCategory = $quiz->questions->where('category_id', $userCategory?->id)->count();
                $isCompleted = $quizUser && $quizUser->status === 'completed';
            @endphp
            @if (($showCompleted && $isCompleted) || (!$showCompleted && (!$quizUser || !$isCompleted)))
                <div class="quiz-card">
                    <h3 style="font-size:1.3rem; font-weight:700; color:#1976d2; margin-bottom:0.5rem;">{{ $quiz->title }}</h3>
                    <div style="margin-bottom:0.7rem; color:#444;">
                        <strong>Timer:</strong> <x-timer-display :seconds="$quiz->timer" /><br>
                        <strong>No. of Questions:</strong> {{ $questionsInCategory }}
                    </div>
                    @if (!$quizUser)
                        <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}" style="margin-bottom:0;">
                            @csrf
                            <button type="submit" class="dashboard-btn">Start Quiz</button>
                        </form>
                    @elseif ($quizUser->status === 'completed')
                        <div style="margin-bottom:0.5rem; color:#388e3c; font-weight:600;">Completed</div>
                        <div style="margin-bottom:0.5rem;">
                            <strong>Your Score:</strong> {{ $quizUser->total_score }} / {{ $questionsInCategory }}
                        </div>
                        <a href="{{ route('user.quizzes.attempts.results', [$quiz, $quizUser]) }}" class="dashboard-btn secondary">View Results</a>
                    @else
                        <div style="margin-bottom:0.5rem; color:#fbc02d; font-weight:600;">In Progress</div>
                        <a href="{{ route('user.quizzes.attempts.show', [$quiz, $quizUser]) }}" class="dashboard-btn">Continue Quiz</a>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
