<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Questions') }}</h2>
    </x-slot>

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

        {{-- ✅ Disable add question if quiz is posted --}}
        @if (!$quiz->is_posted)
            <div x-data="{ showCreate: false }">
                <button @click="showCreate = !showCreate">
                    + Add Question Popup Modal Toggle
                </button>

                <div x-show="showCreate">
                    @include('admin.quizzes.partials.question-form', [
                        'quiz' => $quiz,
                        'action' => route('admin.quizzes.questions.store', $quiz),
                        'method' => 'POST',
                    ])
                </div>
            </div>
        @else
            <div>
                <p><em>This quiz has been posted. Questions cannot be added, edited, or deleted.</em></p>
            </div>
        @endif

        {{-- ✅ Category filter --}}
        <div>
            <label>Filter by Category:</label>
            @foreach ($categories as $category)
                <label>
                    <input type="radio" name="category" :value="'{{ $category->id }}'" x-model="categoryId">
                    {{ $category->name }}
                </label>
            @endforeach
        </div>

        {{-- ✅ List of questions --}}
        <div>
            @foreach ($questions as $index => $question)
                <div x-show="categoryId == '{{ $question->category_id }}'">
                    <h3>
                        {{ $question->question_type === 'text' ? $question->question_content : '[Image Question]' }}
                    </h3>

                    <ul>
                        @foreach ($question->choices as $idx => $choice)
                            <li class="{{ $choice->is_correct ? 'correct' : '' }}">
                                @if ($choice->choice_type === 'text')
                                    {{ $choice->choice_content }}
                                @else
                                    <img src="{{ asset('storage/' . $choice->choice_content) }}" alt="Choice">
                                @endif
                                @if ($choice->is_correct)
                                    <span>✔</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    {{-- ✅ Only show edit/delete if not posted --}}
                    @if (!$quiz->is_posted)
                        <div x-data="{ editing: false }">
                            <button @click="editing = !editing">Edit Popup Modal Toggle</button>

                            <div x-show="editing">
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
        </div>
    </div>
</x-app-layout>
