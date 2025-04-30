<form id="answer-form" method="POST" action="{{ route('user.quizzes.saveAnswer', [$quizUser, $question]) }}">
    @csrf

    <div>
        <h3>{{ $question->question_content }}</h3>

        @foreach ($choices as $choice)
            <div>
                <label>
                    <input type="radio" name="choice_id" value="{{ $choice->id }}">
                    {{ $choice->choice_content }}
                </label>
            </div>
        @endforeach

        <input type="hidden" name="choice_order" value="{{ json_encode($choices->pluck('id')->toArray()) }}">
    </div>

    <div>
        @if ($quizUser->current_question > 1)
            <button type="button" @click="previousQuestion()">← Previous</button>
        @endif

        @if ($quizUser->current_question < count($quizUser->question_order))
            <button type="button" @click="nextQuestion()">Next →</button>
        @endif
    </div>
</form>
