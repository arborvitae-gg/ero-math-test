<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz List') }}</h2>
    </x-slot>

    @php
        $userCategory = \App\Models\Category::findCategoryForGrade($user->grade_level);
        $showCompleted = request('show_completed', '0') === '1';
    @endphp

    <div>
        <form method="GET">
            <input type="hidden" name="show_completed" value="0">
            <button type="submit" {{ !$showCompleted ? ' active' : '' }}">Ongoing/Not Taken
            </button>
        </form>

        <form method="GET">
            <input type="hidden" name="show_completed" value="1">
            <button type="submit" {{ $showCompleted ? ' active' : '' }}">Completed</button>
        </form>
    </div>

    @foreach ($quizzes as $quiz)
        @php
            $quizUser = $quizUsers[$quiz->id] ?? null;
            $questionsInCategory = $quiz->questions->where('category_id', $userCategory?->id)->count();
            $isCompleted = $quizUser && $quizUser->status === 'completed';
        @endphp
        @if (($showCompleted && $isCompleted) || (!$showCompleted && (!$quizUser || !$isCompleted)))
            <div>
                <h3>{{ $quiz->title }}</h3>
                <h3>Timer: <x-timer-display :seconds="$quiz->timer" /></h3>
                <h3>No. of Questions: {{ $questionsInCategory }}</h3>
            </div>
            @if (!$quizUser)
                <div>
                    <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}">
                        @csrf
                        <button type="submit">Start Quiz</button>
                    </form>
                </div>
            @elseif ($quizUser->status === 'completed')
                <div>
                    <h3>Completed</h3>
                    <h3>Your Score: {{ $quizUser->total_score }} /
                        {{ $questionsInCategory }}</h3>
                    <a href="{{ route('user.quizzes.attempts.results', [$quiz, $quizUser]) }}">
                        View Results
                    </a>
                </div>
            @else
                <div>
                    <h3>In Progress</h3>
                    <a href="{{ route('user.quizzes.attempts.show', [$quiz, $quizUser]) }}"
                        class="quiz-btn btn-primary">Continue Quiz</a>
                </div>
            @endif
        @endif
    @endforeach

</x-app-layout>
