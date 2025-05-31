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
                <div style="margin-top: 1rem;"><img src="{{ $question->question_image_url }}" alt="Question Image" class="question-image" style="max-width:100%;border-radius:8px;cursor:zoom-in;"></div>
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
                            <img src="{{ $choice->choice_image_url }}" alt="Choice Image" class="choice-image" style="max-width:60px;max-height:60px;margin-left:0.5rem;vertical-align:middle;cursor:zoom-in;">
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

<!-- Image Modal -->
<div id="image-modal" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(20,30,60,0.7);align-items:center;justify-content:center;">
    <span id="image-modal-close" style="position:absolute;top:32px;right:48px;font-size:3rem;color:#fff;cursor:pointer;font-weight:700;z-index:10001;">&times;</span>
    <img id="image-modal-img" src="" alt="Preview" style="max-width:90vw;max-height:85vh;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.25);background:#fff;z-index:10000;">
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('image-modal');
    const modalImg = document.getElementById('image-modal-img');
    const modalClose = document.getElementById('image-modal-close');
    // Click any .question-image or .choice-image to open modal
    document.querySelectorAll('.question-image, .choice-image').forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', function(e) {
            modal.style.display = 'flex';
            modalImg.src = this.src;
            modalImg.alt = this.alt;
        });
    });
    // Close modal on overlay or close button click
    modalClose.addEventListener('click', function() {
        modal.style.display = 'none';
        modalImg.src = '';
    });
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            modalImg.src = '';
        }
    });
    // Optional: close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modal.style.display = 'none';
            modalImg.src = '';
        }
    });
});
</script>
