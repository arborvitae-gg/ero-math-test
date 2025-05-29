<form id="answer-form" method="POST"
    action="{{ route('user.quizzes.attempts.saveAnswer', [$quizUser->quiz, $quizUser, $question]) }}">
    @csrf

    <div>

        {{-- Question --}}
        <div>
            <h3>
                {{ $question->question_text }}
            </h3>

            @if (!empty($question->question_image))
                <img src="{{ $question->question_image_url }}" alt="Question Image">
            @endif
        </div>

        {{-- Choices --}}
        <div>
            @foreach ($choices as $choice)
                <div>
                    <input type="radio" id="choice_{{ $choice->id }}" name="choice_id" value="{{ $choice->id }}"
                        {{ $existingAttempt && $existingAttempt->question_choice_id === $choice->id ? 'checked' : '' }}>

                    <label for="choice_{{ $choice->id }}">

                        <span>{{ $choice->choice_text }}</span>

                        @if (!empty($choice->choice_image))
                            <img src="{{ $choice->choice_image_url }}" alt="Choice Image">
                        @endif

                    </label>
                </div>
            @endforeach
        </div>

        <input type="hidden" name="choice_order" value="{{ json_encode($choices->pluck('id')->toArray()) }}">
    </div>

    {{-- Arrows/Submit buttons --}}
    <div>
        @if ($quizUser->current_question > 1)
            <button type="submit" name="direction" value="previous">
                Previous
            </button>
        @endif

        @if ($quizUser->current_question < count($quizUser->question_order))
            <button type="submit" name="direction" value="next">
                Next
            </button>
        @else
            <button type="submit" name="direction" value="submit">
                Submit Quiz
            </button>
        @endif
    </div>

</form>
