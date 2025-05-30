{{-- Admin Default Order: questions in admin order, admin choice order --}}
@php
    $questions = $quizUser->quiz->questions->where('category_id', $userCategoryId)->sortBy('id');
    $attemptsByQuestion = $quizUser->attempts->keyBy('question_id');
    $questionNumber = 1;
@endphp
@foreach ($questions as $question)
    @php
        $attempt = $attemptsByQuestion[$question->id] ?? null;
        $choices = $question->choices->sortBy('id');
        $useAdminChoiceOrder = true;
    @endphp
    @include(
        'components.quiz-results-question',
        compact('question', 'questionNumber', 'attempt', 'choices', 'useAdminChoiceOrder'))
    @php $questionNumber++; @endphp
@endforeach
