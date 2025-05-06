<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Questions') }}</h2>
    </x-slot>

    {{-- delete quiz form and button --}}
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

        {{-- Category filter radio buttons --}}
        <div>
            <label>Filter by Category:</label>
            @foreach ($categories as $category)
                <label>
                    <input type="radio" name="category" :value="'{{ $category->id }}'" x-model="categoryId">
                    {{ $category->name }}
                </label>
            @endforeach
        </div>

        {{-- Toggleable Pop-up modal Add Question button --}}
        <div x-data="{ showCreate: false }">
            <button @click="showCreate = !showCreate">
                + Add Question Popup Modal Toggle
            </button>

            {{-- Model add question form, form blade file located in views/admin/partials/question-form.blade.php --}}
            <div x-show="showCreate">
                @include('admin.quizzes.partials.question-form', [
                    'quiz' => $quiz,
                    'action' => route('admin.quizzes.questions.store', $quiz),
                    'method' => 'POST',
                ])
            </div>

        </div>


        {{-- List of questions table --}}
        <div>
            {{-- loops through all the questions in the database --}}
            @foreach ($questions as $index => $question)
                <div x-show="categoryId == '{{ $question->category_id }}' ">
                    <h3>
                        {{ $question->question_type === 'text' ? $question->question_content : '[Image Question]' }}
                    </h3>

                    <ul>
                        {{-- loops through all the choices per question in the database --}}
                        @foreach ($question->choices as $idx => $choice)
                            <li class="{{ $choice->is_correct }}">
                                @if ($choice->choice_type === 'text')
                                    {{ $choice->choice_content }}
                                @else
                                    <img src="{{ asset('storage/' . $choice->choice_content) }}" alt="Choice">
                                @endif

                                {{-- adds check mark if choice is correct --}}
                                @if ($choice->is_correct)
                                    <span>✔</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <div>
                        {{-- Toggleable Pop-up modal Edit Question button --}}
                        <div x-data="{ editing: false }">
                            <button @click="editing = !editing">Edit Popup Modal Toggle</button>

                            {{-- Model edit question form, form blade file located in views/admin/partials/question-form.blade.php --}}
                            <div x-show="editing">
                                @include('admin.quizzes.partials.question-form', [
                                    'quiz' => $quiz,
                                    'question' => $question,
                                    'action' => route('admin.quizzes.questions.update', [$quiz, $question]),
                                    'method' => 'PATCH',
                                ])
                            </div>
                        </div>

                        {{-- delete question form and button --}}
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
