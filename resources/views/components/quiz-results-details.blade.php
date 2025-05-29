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
    @php
        // Get the question order from the quizUser model (array of question IDs)
        $questionOrder = $quizUser->question_order ?? [];
        // Map attempts by question_id for fast lookup
        $attemptsByQuestion = $quizUser->attempts->keyBy('question_id');
        // Get choice orders (question_id => [choice_id,...])
        $choiceOrders = $quizUser->choice_orders ?? [];
    @endphp
    @foreach ($questionOrder as $i => $questionId)
        @php
            $attempt = $attemptsByQuestion[$questionId] ?? null;
            $question = $attempt ? $attempt->question : \App\Models\Question::find($questionId);
            $choiceOrder = $choiceOrders[$questionId] ?? ($question ? $question->choices->pluck('id')->toArray() : []);
            $choices = $question
                ? $question->choices->whereIn('id', $choiceOrder)->sortBy(function ($c) use ($choiceOrder) {
                    return array_search($c->id, $choiceOrder);
                })
                : collect();
        @endphp

        <div id="question-{{ $questionId }}">
            <h3>{{ $i + 1 }}. {{ $question ? $question->question_text : '[Question not found]' }}</h3>

            @if ($question && !empty($question->question_image))
                <img src="{{ $question->question_image_url }}" alt="Question Image">
            @endif

            <ul>
                @php $isSkipped = $attempt && $attempt->question_choice_id === null; @endphp
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
    @endforeach
</div>
