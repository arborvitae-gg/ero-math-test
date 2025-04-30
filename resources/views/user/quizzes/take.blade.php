<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz in Progress') }}</h2>
    </x-slot>

    <div x-data="quizHandler()">
        <div>
            <p>Question {{ $quizUser->current_question }} out of {{ count($quizUser->question_order) }}</p>
        </div>

        {{-- Form moved to a partial --}}
        @include('user.quizzes.partials.answer-form', [
            'quizUser' => $quizUser,
            'question' => $question,
            'choices' => $choices,
        ])

        {{-- Submit Final Quiz Button --}}
        <form method="POST" action="{{ route('user.quizzes.submit', $quizUser) }}"
            onsubmit="return confirm('Are you sure you want to submit the quiz?');">
            @csrf
            <button type="submit">Submit Quiz</button>
        </form>
    </div>

    {{-- Scripts moved to partial --}}
    @include('user.quizzes.partials.quiz-script')
</x-app-layout>
