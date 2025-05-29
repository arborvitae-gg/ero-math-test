<x-app-layout>

    <x-slot name="header">
        <h2>{{ $quiz->title }} {{ __(' Questions') }}</h2>
    </x-slot>

    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.quizzes.index') }}">
            &larr; Back to Quizzes</a> {{-- &larr: back arrow --}}
    </div>

    {{-- Saves selected category on page reloada --}}
    @php
        $defaultCategory = $categories->first();
        $localStorageKey = 'categoryId_quiz_' . $quiz->id;
    @endphp

    <div x-data="{
        categoryId: localStorage.getItem('{{ $localStorageKey }}') || '{{ $defaultCategory->id }}',
        init() {
            this.$watch('categoryId', value => localStorage.setItem('{{ $localStorageKey }}', value))
        }
    }">

        {{-- Disable question-form if quiz is posted --}}
        @if (!$quiz->is_posted)
            <div x-data="{ showAddQuestionForm: false }">
                <button @click="showAddQuestionForm = !showAddQuestionForm">
                    + Add Question
                </button>

                <div x-show="showAddQuestionForm">
                    @include('admin.quizzes.partials.question-form', [
                        'quiz' => $quiz,
                        'action' => route('admin.quizzes.questions.store', $quiz),
                        'method' => 'POST',
                    ])
                </div>

            </div>
        @else
            <p><em>This quiz has been posted. Questions cannot be added, edited, or deleted.</em></p>
        @endif

        {{-- Category filter --}}
        <label>Filter by Category:</label>
        @foreach ($categories as $category)
            <label>
                <input type="radio" name="category" :value="'{{ $category->id }}'" x-model="categoryId">
                {{ $category->name }}
            </label>
        @endforeach

        {{-- Group questions by category --}}
        @php
            $questionsByCategory = $questions->groupBy('category_id');
        @endphp

        {{-- List of questions --}}
        @foreach ($categories as $category)
            @php
                $questionNumber = 1;
            @endphp

            @foreach ($questionsByCategory[$category->id] ?? [] as $index => $question)
                <div x-show="categoryId == '{{ $category->id }}'">
                    <h3>
                        {{ $questionNumber++ }}. {{ $question->question_text }}
                    </h3>
                    @if (!empty($question->question_image))
                        <img src="{{ $question->question_image_url }}" alt="Question Image">
                    @endif
                    <ul>
                        @foreach ($question->choices as $idx => $choice)
                            <li class="{{ $choice->is_correct ? 'correct' : '' }}">
                                {{ $choice->choice_text }}
                                @if (!empty($choice->choice_image))
                                    <img src="{{ $choice->choice_image_url }}" alt="Choice Image">
                                @endif
                                @if ($choice->is_correct)
                                    <span>✔</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    {{-- Only show edit/delete if not posted --}}
                    @if (!$quiz->is_posted)
                        <div x-data="{ showEditQuestionForm: false }">
                            <button @click="showEditQuestionForm = !showEditQuestionForm">Edit</button>
                            <div x-show="showEditQuestionForm">
                                @include('admin.quizzes.partials.question-form', [
                                    'quiz' => $quiz,
                                    'question' => $question,
                                    'action' => route('admin.quizzes.questions.update', [$quiz, $question]),
                                    'method' => 'PATCH',
                                ])
                            </div>
                        </div>
                        <form action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}"
                            method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endforeach

    </div>
</x-app-layout>
