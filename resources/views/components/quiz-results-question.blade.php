{{-- Single question/choices rendering for quiz results --}}
@php
    // $question, $questionNumber, $attempt, $choices, $useAdminChoiceOrder are expected from parent include
    $isSkipped = $attempt && $attempt->question_choice_id === null;
@endphp
<div id="question-{{ $useAdminChoiceOrder ? 'admin' : 'user' }}-{{ $question->id }}">
    <h3>{{ $questionNumber }}. {{ $question->question_text }}</h3>
    @if ($question && !empty($question->question_image))
        <img src="{{ $question->question_image_url }}" alt="Question Image">
    @endif
    <ul>
        @foreach ($choices as $choice)
            @php
                $isUserChoice = $attempt && $attempt->choice && $attempt->choice->id === $choice->id;
                $isCorrectChoice = $choice->is_correct;
                if ($isCorrectChoice && $isUserChoice) {
                    $choiceClass = 'choice-correct-user';
                } elseif ($isCorrectChoice) {
                    $choiceClass = 'choice-correct';
                } elseif ($isUserChoice) {
                    $choiceClass = 'choice-wrong-user';
                } else {
                    $choiceClass = 'choice-default';
                }
            @endphp
            <li class="choice-item {{ $choiceClass }}" data-choice-id="{{ $choice->id }}">
                <div>
                    {{ $choice->choice_text }}
                    @if (!empty($choice->choice_image))
                        <img src="{{ $choice->choice_image_url }}" alt="Choice Image">
                    @endif
                </div>
                <div>
                    @if ($isSkipped)
                        @if ($isCorrectChoice)
                            <span class="label label-success">✔ Correct answer</span>
                        @endif
                    @else
                        @if ($isCorrectChoice && $isUserChoice)
                            <span class="label label-success">✔ Your answer is correct</span>
                        @elseif ($isCorrectChoice)
                            <span class="label label-success">✔ Correct answer</span>
                        @elseif ($isUserChoice)
                            <span class="label label-error">✖ Your answer</span>
                        @endif
                    @endif
                </div>
            </li>
        @endforeach
        @if ($isSkipped)
            <li class="choice-item choice-skipped">
                <span class="label label-warning">⏭ Skipped</span>
            </li>
        @endif
    </ul>
</div>
