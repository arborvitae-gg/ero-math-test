<form id="answer-form" method="POST" x-data="quizHandler()"
    action="{{ route('user.quizzes.attempts.saveAnswer', [$quizUser->quiz, $quizUser, $question]) }}">
    @csrf

    <div class="question">
        <h3 class="question-text">
            {{ $question->question_text }}
        </h3>
        @if (!empty($question->question_image))
            <img src="{{ $question->question_image_url }}" alt="Question Image" class="question-image">
        @endif
        
        <div class="choices-container">
            @foreach ($choices as $choice)
                <div class="choice-item">
                    <input type="radio" 
                        class="choice-radio" 
                        id="choice_{{ $choice->id }}"
                        name="choice_id" 
                        value="{{ $choice->id }}"
                        {{ $existingAttempt && $existingAttempt->question_choice_id === $choice->id ? 'checked' : '' }}>
                    <label class="choice-label" for="choice_{{ $choice->id }}">
                        <span class="choice-text">{{ $choice->choice_text }}</span>
                        @if (!empty($choice->choice_image))
                            <img src="{{ $choice->choice_image_url }}" alt="Choice Image" class="choice-image">
                        @endif
                    </label>
                </div>
            @endforeach
        </div>

        <input type="hidden" name="choice_order" value="{{ json_encode($choices->pluck('id')->toArray()) }}">
    </div>

    <div class="navigation">
        @if ($quizUser->current_question > 1)
            <button type="button" @click="previousQuestion" class="nav-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Previous
            </button>
        @endif

        @if ($quizUser->current_question < count($quizUser->question_order))
            <button type="button" @click="nextQuestion" class="nav-button">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        @else
            <button type="submit" name="direction" value="submit" class="nav-button submit-button">
                Submit Quiz
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        @endif
    </div>
</form>
