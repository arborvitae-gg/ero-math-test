<form id="answer-form" method="POST"
    action="{{ route('user.quizzes.attempts.saveAnswer', [$quizUser->quiz, $quizUser, $question]) }}">
    @csrf

    <div class="question">
        <h3>{{ $question->question_content }}</h3>
        @foreach ($choices as $choice)
            <div>
                <label>
                    <input type="radio" name="choice_id" value="{{ $choice->id }}"
                        {{ $existingAttempt && $existingAttempt->question_choice_id === $choice->id ? 'checked' : '' }}>
                    {{ $choice->choice_content }}
                </label>
            </div>
        @endforeach

        <input type="hidden" name="choice_order" value="{{ json_encode($choices->pluck('id')->toArray()) }}">
    </div>

    <div class="navigation">
        @if ($quizUser->current_question > 1)
            <button type="submit" name="direction" value="previous">← Previous</button>
        @endif

        @if ($quizUser->current_question < count($quizUser->question_order))
            <button type="submit" name="direction" value="next">Next →</button>
        @else
            <button type="submit" name="direction" value="submit">Submit Quiz</button>
        @endif
    </div>
</form>
