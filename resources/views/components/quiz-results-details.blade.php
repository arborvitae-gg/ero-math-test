{{-- resources/views/components/quiz-results-details.blade.php --}}
<div>
    @if (!isset($hideUser) || !$hideUser)
        <h3>User: </h3>
        <p>{{ $quizUser->user->first_name . ' ' . $quizUser->user->last_name }}</p>
    @endif

    <h3>Category: </h3>
    <p>{{ $quizUser->category->name }}</p>

    <h3>Score:</h3>
    <p>
        {{ $quizUser->attempts->where('is_correct', true)->count() }}
        /
        {{ $quizUser->attempts->count() }}
    </p>
</div>

<div>
    @foreach ($quizUser->attempts as $i => $attempt)
        @php
            $question = $attempt->question;
        @endphp

        <div id="question-{{ $question->id }}">

            <h3>{{ $i + 1 }}. {{ $question->question_text }}</h3>

            @if (!empty($question->question_image))
                <img src="{{ $question->question_image_url }}" alt="Question Image">
            @endif

            <ul>
                @foreach ($question->choices as $choice)
                    @php
                        $isUserChoice = $attempt->choice && $attempt->choice->id === $choice->id;
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
                            @if ($isCorrectChoice && $isUserChoice)
                                <span class="label label-success">✔ Your answer is correct</span>
                            @elseif ($isCorrectChoice)
                                <span class="label label-success">✔ Correct answer</span>
                            @elseif ($isUserChoice)
                                <span class="label label-error">✖ Your answer</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    @endforeach
</div>
