<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz List') }}</h2>
    </x-slot>

    @php
        $userCategory = \App\Models\Category::findCategoryForGrade($user->grade_level);
    @endphp

    @foreach ($quizzes as $quiz)
        @php
            $quizUser = $quizUsers[$quiz->id] ?? null;
            $questionsInCategory = $quiz->questions->where('category_id', $userCategory?->id)->count();
        @endphp

        <div>
            <h3>{{ $quiz->title }}</h3>
            <h3>Timer: {{ $quiz->timer ? $quiz->timer . 's' : 'No Timer' }}</h3>
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
    @endforeach

</x-app-layout>
