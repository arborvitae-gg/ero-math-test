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
        <!-- Filter by Category -->
        <div>
            <label>Filter by Category:</label>
            @foreach ($categories as $category)
                <label>
                    <input type="radio" name="category" :value="'{{ $category->id }}'" x-model="categoryId">
                    {{ $category->name }}
                </label>
            @endforeach
        </div>

        <!-- Toggle Button -->
        <div x-data="{ showCreate: false }">
            <button @click="showCreate = !showCreate">
                + Add Question Popup Modal Toggle
            </button>

            <!-- Add Question Form -->
            <div x-show="showCreate">
                @include('admin.partials.question-form', [
                    'quiz' => $quiz,
                    'action' => route('admin.quizzes.questions.store', $quiz),
                    'method' => 'POST',
                ])
            </div>

        </div>


        <!-- Questions Grid -->
        <div>
            @foreach ($questions as $index => $question)
                <div x-show="categoryId == '{{ $question->category_id }}' ">
                    <h3>
                        {{ $question->question_type === 'text' ? $question->question_content : '[Image Question]' }}
                    </h3>

                    <ul>
                        @foreach ($question->choices as $idx => $choice)
                            <li class="{{ $choice->is_correct }}">
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

                    <div>
                        <div x-data="{ editing: false }">
                            <button @click="editing = !editing">Edit Popup Modal Toggle</button>

                            <div x-show="editing">
                                @include('admin.partials.question-form', [
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
