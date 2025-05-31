<form id="answer-form" method="POST"
    action="{{ route('user.quizzes.attempts.saveAnswer', [$quizUser->quiz, $quizUser, $question]) }}">
    @csrf

    <div class="quiz-attempt-card">
        {{-- Title and Question Number --}}
        <div style="text-align:center; margin-bottom: 1.5rem;">
            <div style="font-size:2rem; font-weight:800; color:#1a237e; letter-spacing:1px; margin-bottom:0.3rem;">
                {{ $quizUser->quiz->title }}
            </div>
            <div style="font-size:1.15rem; color:#1976d2; font-weight:600; margin-bottom:0.2rem;">
                Question {{ $quizUser->current_question }} of {{ count($quizUser->question_order) }}
            </div>
            @if(isset($quizDuration) && $quizDuration !== null)
                <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 0.2rem;">
                    <div style="background: #e3f2fd; color: #1976d2; font-weight:700; font-size:1.15rem; border-radius: 8px; padding: 0.4rem 1.2rem; box-shadow: 0 2px 8px rgba(25,118,210,0.08); letter-spacing: 1px; min-width: 110px;">
                        <span id="quiz-timer">{{ gmdate('H:i:s', $remainingTime ?? $quizDuration) }}</span>
                    </div>
                </div>
            @endif
        </div>
        {{-- Question --}}
        <div class="quiz-attempt-question">
            {{ $question->question_text }}
            @if (!empty($question->question_image))
                <div style="margin-top: 1rem;"><img src="{{ $question->question_image_url }}" alt="Question Image" style="max-width:100%;border-radius:8px;"></div>
            @endif
        </div>
        {{-- Choices --}}
        <div class="quiz-attempt-choices">
            @foreach ($choices as $choice)
                <div class="quiz-attempt-choice">
                    <input type="radio" id="choice_{{ $choice->id }}" name="choice_id" value="{{ $choice->id }}"
                        {{ $existingAttempt && $existingAttempt->question_choice_id === $choice->id ? 'checked' : '' }}>
                    <label for="choice_{{ $choice->id }}">
                        <span>{{ $choice->choice_text }}</span>
                        @if (!empty($choice->choice_image))
                            <img src="{{ $choice->choice_image_url }}" alt="Choice Image" style="max-width:60px;max-height:60px;margin-left:0.5rem;vertical-align:middle;">
                        @endif
                    </label>
                </div>
            @endforeach
        </div>
        <input type="hidden" name="choice_order" value="{{ json_encode($choices->pluck('id')->toArray()) }}">
        {{-- Arrows/Submit buttons --}}
        <div class="quiz-attempt-nav">
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
    </div>
</form>
