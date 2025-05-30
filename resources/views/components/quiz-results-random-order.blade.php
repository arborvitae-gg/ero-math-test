{{-- Quiz User Order: questions and choices in user-randomized order --}}
@php
    $questionOrder = $quizUser->question_order ?? [];
    $attemptsByQuestion = $quizUser->attempts->keyBy('question_id');
    $choiceOrders = $quizUser->choice_orders ?? [];
    $i = 0;
@endphp
@foreach ($questionOrder as $questionId)
    @php
        $attempt = $attemptsByQuestion[$questionId] ?? null;
        $question = $attempt ? $attempt->question : \App\Models\Question::find($questionId);
        if (!$question || $question->category_id != $userCategoryId) {
            continue;
        }
        $choiceOrder = $choiceOrders[$questionId] ?? ($question ? $question->choices->pluck('id')->toArray() : []);
        $choices = $question->choices->whereIn('id', $choiceOrder)->sortBy(function ($c) use ($choiceOrder) {
            return array_search($c->id, $choiceOrder);
        });
        $useAdminChoiceOrder = false;
        $questionNumber = ++$i;
    @endphp
    @include(
        'components.quiz-results-question',
        compact('question', 'questionNumber', 'attempt', 'choices', 'useAdminChoiceOrder'))
@endforeach
