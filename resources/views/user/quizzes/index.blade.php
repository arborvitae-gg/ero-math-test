<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Available Quizzes') }}</h2>
    </x-slot>

    @php
        $userCategory = \App\Models\Category::findCategoryForGrade($user->grade_level);
    @endphp

    <div>
        @foreach ($quizzes as $quiz)
            @php
                $quizUser = $quizUsers[$quiz->id] ?? null;
                $questionsInCategory = $quiz->questions->where('category_id', $userCategory?->id)->count();
            @endphp

            <div>
                <h3>{{ $quiz->title }}</h3>
                <p>Timer: {{ $quiz->timer ? $quiz->timer . ' seconds' : 'No Timer' }}</p>
                <p>Questions available: {{ $questionsInCategory }}</p>

                <div>
                    {{-- @if (!$quizUser) --}}
                    @if ($quizUser->status === 'not_started')
                        <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}">
                            @csrf
                            <button type="submit">Start Quiz</button>
                        </form>
                    @elseif ($quizUser->status === 'completed')
                        <p>Completed</p>
                        @if ($quizUser->can_view_score)
                            <a href="{{ route('user.quizzes.attempts.results', [$quiz, $quizUser]) }}">View Results</a>
                        @else
                            <p>Waiting for results...</p>
                        @endif
                        {{-- <a href="{{ route('user.quizzes.certificate', [$quiz, $quizUser]) }}">Download Certificate</a> --}}
                    @else
                        <a href="{{ route('user.quizzes.attempts.show', [$quiz, $quizUser]) }}">Continue Quiz</a>
                    @endif
                </div>
            </div>
            <hr>
        @endforeach
    </div>
</x-app-layout>
