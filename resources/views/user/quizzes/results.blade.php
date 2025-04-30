<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz Results') }}</h2>
    </x-slot>

    <div class="quiz-results">
        <h2>Quiz Results: {{ $quizUser->quiz->title }}</h2>
        <p>Score: {{ $quizUser->total_score }} / {{ count($quizUser->question_order) }}</p>

        @foreach ($questions as $index => $question)
            <div class="question-result">
                <h4>Question {{ $index + 1 }}: {{ $question->question_content }}</h4>

                @php
                    $attempt = $quizUser->attempts->firstWhere('question_id', $question->id);
                    $userChoice = $attempt ? $attempt->question_choice_id : null;
                    $correctChoice = $question->choices->firstWhere('is_correct', true)->id;
                @endphp

                <ul>
                    @foreach ($question->choices as $choice)
                        <li
                            @if ($choice->id == $userChoice) class="{{ $choice->id == $correctChoice ? 'correct' : 'incorrect' }}" @endif>
                            {{ $choice->choice_content }}
                            @if ($choice->id == $correctChoice)
                                <strong>(Correct Answer)</strong>
                            @endif
                            @if ($choice->id == $userChoice)
                                <em>(Your Answer)</em>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div>
        <a href="{{ route('user.dashboard') }}">Return to Dashboard</a>
    </div>
</x-app-layout>
