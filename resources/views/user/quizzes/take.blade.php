<x-app-layout>
    <x-slot name="header">
        <h2>{{ $quizUser->quiz->title }}</h2>
    </x-slot>

    <div x-data="quizHandler()">
        <div>
            <p>Question {{ $quizUser->current_question }} of {{ count($quizUser->question_order) }}</p>
        </div>

        {{-- partials/answer-form.blade.php --}}
        @include('user.quizzes.partials.answer-form', [
            'quizUser' => $quizUser,
            'question' => $question,
            'choices' => $choices,
        ])
    </div>

</x-app-layout>
