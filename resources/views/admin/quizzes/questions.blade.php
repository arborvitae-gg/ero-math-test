<x-app-layout>

    <x-slot name="header">
        <h2 class="dashboard-title">{{ $quiz->title }} {{ __(' Questions') }}</h2>
    </x-slot>

    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.quizzes.index') }}" class="admin-back-btn">
            &larr; Back to Quizzes</a>
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
                <button @click="showAddQuestionForm = true" class="admin-add-btn">
                    + Add Question
                </button>
                <!-- Modal Popup for Add Question -->
                <div x-show="showAddQuestionForm"
                    style="position: fixed; inset: 0; z-index: 1001; display: flex; align-items: center; justify-content: center; background: rgba(20,30,60,0.35); backdrop-filter: blur(1.5px);"
                    x-cloak>
                    <div @click.away="showAddQuestionForm = false" style="background: #fff; border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.25); padding: 2.5rem 2rem 2rem 2rem; min-width: 340px; max-width: 520px; width: 100%; position: relative; z-index: 1002; display: flex; flex-direction: column; align-items: stretch; max-height: 80vh; overflow-y: auto; margin: auto;">
                        <button @click="showAddQuestionForm = false" style="position: absolute; top: 1.1rem; right: 1.1rem; background: none; border: none; font-size: 2rem; color: #888; cursor: pointer; transition: color 0.2s;" @mouseover="$el.style.color='#1976d2'" @mouseleave="$el.style.color='#888'">&times;</button>
                        <h3 style="margin-bottom: 1.5rem; text-align: center; font-size: 1.35rem; font-weight: 600; color: #1a237e; letter-spacing: 0.01em;">Add Question</h3>
                        @include('admin.quizzes.partials.question-form', [
                            'quiz' => $quiz,
                            'action' => route('admin.quizzes.questions.store', $quiz),
                            'method' => 'POST',
                        ])
                    </div>
                </div>
            </div>
        @else
            <p><em>This quiz has been posted. Questions cannot be added, edited, or deleted.</em></p>
        @endif

        {{-- Category filter --}}
        <label style="font-weight:600; color:#1a237e; margin-top:1.2rem;">Filter by Category:</label>
        <div class="admin-category-filter">
        @foreach ($categories as $category)
            <label class="admin-category-radio">
                <input type="radio" name="category" :value="'{{ $category->id }}'" x-model="categoryId">
                <span>{{ $category->name }}</span>
            </label>
        @endforeach
        </div>

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
                <div x-show="categoryId == '{{ $category->id }}'" class="admin-question-card">
                    <div class="admin-question-number">
                        {{ $questionNumber++ }}.
                    </div>
                    <div class="admin-question-title">
                        {{ $question->question_text }}
                    </div>
                    @if (!empty($question->question_image))
                        <div class="question-image-container">
                            <img src="{{ $question->question_image_url }}" alt="Question Image" class="question-image">
                            @if(config('app.debug'))
                                <div class="debug-info">
                                    Image path: {{ $question->question_image }}<br>
                                    Full URL: {{ $question->question_image_url }}
                                </div>
                            @endif
                        </div>
                    @endif
                    <ul style="margin-bottom:0.7rem;">
                        @foreach ($question->choices as $idx => $choice)
                            <li class="admin-choice{{ $choice->is_correct ? ' correct' : '' }}">
                                {{ $choice->choice_text }}
                                @if (!empty($choice->choice_image))
                                    <div class="choice-image-container">
                                        <img src="{{ $choice->choice_image_url }}" alt="Choice Image" class="choice-image">
                                        @if(config('app.debug'))
                                            <div class="debug-info">
                                                Image path: {{ $choice->choice_image }}<br>
                                                Full URL: {{ $choice->choice_image_url }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if ($choice->is_correct)
                                    <span>✔</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    {{-- Only show edit/delete if not posted --}}
                    @if (!$quiz->is_posted)
                        <div x-data="{ showEditQuestionForm: false }" class="admin-question-actions">
                            <button @click="showEditQuestionForm = !showEditQuestionForm">Edit</button>
                            <form action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}"
                                method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-action-btn danger">Delete</button>
                            </form>
                            <div x-show="showEditQuestionForm">
                                @include('admin.quizzes.partials.question-form', [
                                    'quiz' => $quiz,
                                    'question' => $question,
                                    'action' => route('admin.quizzes.questions.update', [$quiz, $question]),
                                    'method' => 'PATCH',
                                ])
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endforeach

    </div>
</x-app-layout>
