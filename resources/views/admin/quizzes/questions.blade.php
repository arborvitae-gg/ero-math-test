<x-app-layout>

    <x-slot name="header">
        <h2 class="dashboard-title">{{ $quiz->title }} {{ __(' Questions') }}</h2>
    </x-slot>

    <style>
        .admin-questions-main-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 2rem 1.5rem;
        }
        .admin-question-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(25,118,210,0.08);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .admin-question-card:hover {
            box-shadow: 0 8px 32px rgba(25,118,210,0.13);
            transform: translateY(-2px) scale(1.02);
        }
        .admin-question-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: #1a237e;
            margin-bottom: 0.7rem;
        }
        .admin-question-number {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1976d2;
            margin-bottom: 0.3rem;
        }
        .question-image-container {
            margin-bottom: 1rem;
            text-align: center;
        }
        .question-image {
            max-width: 100%;
            max-height: 260px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(25,118,210,0.08);
        }
        .choice-image-container {
            display: inline-block;
            margin-left: 0.5rem;
            vertical-align: middle;
        }
        .choice-image {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(25,118,210,0.10);
            margin-left: 1rem;
        }
        .admin-choice {
            padding: 0.7rem 1rem;
            border-radius: 7px;
            margin-bottom: 0.5rem;
            background: #f5f7fa;
            font-size: 1.08rem;
            color: #222;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .admin-choice.correct {
            background: #e3fbe3;
            color: #2e7d32;
            font-weight: 700;
        }
        .admin-category-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .admin-category-radio {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f1f6fb;
            border-radius: 12px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            color: #1976d2;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border 0.2s, background 0.2s;
        }
        .admin-category-radio input[type="radio"]:checked + span {
            color: #fff;
            background: #1976d2;
            border-radius: 8px;
            padding: 0.2rem 0.7rem;
        }
        @media (max-width: 800px) {
            .admin-questions-main-container {
                padding: 1.2rem 0.3rem 1rem 0.3rem;
            }
            .admin-question-card {
                padding: 1rem 0.5rem;
            }
        }
    </style>

    <div class="admin-questions-main-container">
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
                            </div>
                        @endif
                        <ul style="margin-bottom:0.7rem;">
                            @foreach ($question->choices as $idx => $choice)
                                <li class="admin-choice{{ $choice->is_correct ? ' correct' : '' }}">
                                    {{ $choice->choice_text }}
                                    @if (!empty($choice->choice_image))
                                        <div class="choice-image-container">
                                            <img src="{{ $choice->choice_image_url }}" alt="Choice Image" class="choice-image">
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
    </div>

    <!-- Image Modal -->
    <div id="image-modal" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(20,30,60,0.7);align-items:center;justify-content:center;">
        <span id="image-modal-close" style="position:absolute;top:32px;right:48px;font-size:3rem;color:#fff;cursor:pointer;font-weight:700;z-index:10001;">&times;</span>
        <img id="image-modal-img" src="" alt="Preview" style="max-width:90vw;max-height:85vh;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.25);background:#fff;z-index:10000;">
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('image-modal');
        const modalImg = document.getElementById('image-modal-img');
        const modalClose = document.getElementById('image-modal-close');
        // Click any .question-image or .choice-image to open modal
        document.querySelectorAll('.question-image, .choice-image').forEach(img => {
            img.style.cursor = 'zoom-in';
            img.addEventListener('click', function(e) {
                modal.style.display = 'flex';
                modalImg.src = this.src;
                modalImg.alt = this.alt;
            });
        });
        // Close modal on overlay or close button click
        modalClose.addEventListener('click', function() {
            modal.style.display = 'none';
            modalImg.src = '';
        });
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                modalImg.src = '';
            }
        });
        // Optional: close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                modal.style.display = 'none';
                modalImg.src = '';
            }
        });
    });
    </script>

</x-app-layout>
