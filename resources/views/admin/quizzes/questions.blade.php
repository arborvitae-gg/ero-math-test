<x-app-layout>
    <div class="top-container">
        <h1>ADMIN |</h1>
        <h2>{{ __('Questions') }}</h2>
    </div>

    @php
        $defaultCategory = $categories->first();
        $localStorageKey = 'categoryId_quiz_' . $quiz->id;
    @endphp

    <div x-data="{
        categoryId: localStorage.getItem('{{ $localStorageKey }}') || '{{ $defaultCategory->id }}',
        init() {
            this.$watch('categoryId', value => localStorage.setItem('{{ $localStorageKey }}', value))
        }
    }" class="questions-body">

        {{-- ✅ Disable add question if quiz is posted --}}
        @if (!$quiz->is_posted)
            <div x-data="{ showCreate: false }" class="add-question-btn">
                <button @click="showCreate = !showCreate">
                    + Add Question
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
        <div class="filter-category">
            <label>Filter by Category:</label>
            @foreach ($categories as $category)
                <label>
                    <input type="radio" name="category" :value="'{{ $category->id }}'" x-model="categoryId">
                    {{ $category->name }}
                </label>
            @endforeach
        </div>

        {{-- ✅ List of questions --}}
        <div class="question-table">
            @foreach ($questions as $index => $question)
                <div class="question-table-data" x-show="categoryId == '{{ $question->category_id }}'">
                    <div class="table-data-title">
                    <h3>
                        {{ $question->question_text }}
                    </h3>
                    @if (!empty($question->question_image))
                        <img id="table-data-image" src="{{ $question->question_image_url }}" alt="Question Image">
                    @endif
                    </div>
                    <ul>
                        @foreach ($question->choices as $idx => $choice)
                            <li class="{{ $choice->is_correct ? 'correct' : '' }}">
                                {{ $choice->choice_text }}
                                @if (!empty($choice->choice_image))
                                    <img id="table-data-image" src="{{ $choice->choice_image_url }}" alt="Choice Image">
                                @endif
                                @if ($choice->is_correct)
                                   <span>✔</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    {{-- Only show edit/delete if not posted --}}
                    @if (!$quiz->is_posted)
                        <div class="edit-btn-container" x-data="{ editing: false }">
                            <button id="table-data-btn" @click="editing = !editing">Edit</button>

                            <div x-show="editing">
                                @include('admin.quizzes.partials.question-form', [
                                    'quiz' => $quiz,
                                    'question' => $question,
                                    'action' => route('admin.quizzes.questions.update', [$quiz, $question]),
                                    'method' => 'PATCH',
                                ])
                            </div>
                        </div>

                        <form class="delete-btn-container" action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}"
                            method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button id="table-data-btn" type="submit">Delete</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
