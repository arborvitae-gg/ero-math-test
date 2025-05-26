@extends('layouts.app')

@section('content')
    <div class="questions-container">
        <div class="questions-header">
            <div>
                <h2>{{ $quiz->title }} - Questions</h2>
                <p>Manage questions for this quiz</p>
            </div>
            <button class="add-question-btn" onclick="document.getElementById('createQuestionModal').style.display='block'">
                <i class="fa-solid fa-plus"></i>
                Add Question
            </button>
        </div>

        <div class="questions-grid">
            @foreach ($questions as $question)
                <div class="question-card">
                    <div class="question-header">
                        <span class="category-badge">{{ $question->category->name }}</span>
                        <div class="question-actions">
                            <button class="action-btn edit" onclick="showEditQuestionModal({{ $question->id }})">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.quizzes.questions.destroy', ['quiz' => $quiz, 'question' => $question]) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this question?');"
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="question-text">
                        {{ $question->question_text }}
                    </div>

                    @if ($question->question_image)
                        <div class="question-image">
                            <img src="{{ $question->question_image_url }}" alt="Question Image">
                        </div>
                    @endif

                    <div class="choices-list">
                        @foreach ($question->choices as $index => $choice)
                            <div class="choice-item {{ $index === 0 ? 'correct' : '' }}">
                                {{ $choice->choice_text }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Create Question Modal -->
    <div id="createQuestionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Question</h3>
                <span class="close" onclick="document.getElementById('createQuestionModal').style.display='none'">&times;</span>
            </div>
            <form method="POST" action="{{ route('admin.quizzes.questions.store', $quiz) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="question_text">Question Text</label>
                    <textarea id="question_text" name="question_text" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="question_image">Question Image (optional)</label>
                    <input type="file" id="question_image" name="question_image" accept="image/*">
                </div>
                <div class="choices-container">
                    <label>Choices (first one will be correct)</label>
                    @for ($i = 0; $i < 4; $i++)
                        <div class="form-group">
                            <input type="text" name="choices[{{ $i }}][choice_text]" placeholder="Choice {{ $i + 1 }}" required>
                        </div>
                    @endfor
                </div>
                <button type="submit" class="submit-btn">Add Question</button>
            </form>
        </div>
    </div>

    <style>
        .questions-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .questions-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .questions-header h2 {
            font-size: 2rem;
            color: rgb(19, 15, 64);
            margin: 0 0 0.5rem;
        }

        .questions-header p {
            color: #666;
            margin: 0;
        }

        .add-question-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: rgb(19, 15, 64);
            color: white;
            border: none;
            border-radius: 24px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .add-question-btn:hover {
            background: rgb(59, 54, 140);
        }

        .questions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .question-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
        }

        .question-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .category-badge {
            padding: 0.25rem 0.75rem;
            background: rgb(224, 231, 255);
            color: rgb(40, 70, 199);
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .question-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .action-btn.edit {
            background: rgb(254, 243, 199);
            color: rgb(146, 64, 14);
        }

        .action-btn.delete {
            background: rgb(254, 226, 226);
            color: rgb(185, 28, 28);
        }

        .question-text {
            font-size: 1rem;
            color: rgb(19, 15, 64);
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .question-image {
            margin-bottom: 1rem;
        }

        .question-image img {
            width: 100%;
            border-radius: 8px;
        }

        .choices-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .choice-item {
            padding: 0.75rem;
            border-radius: 8px;
            background: rgb(243, 244, 246);
            color: rgb(55, 65, 81);
        }

        .choice-item.correct {
            background: rgb(220, 252, 231);
            color: rgb(22, 101, 52);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 2rem;
            width: 90%;
            max-width: 600px;
            border-radius: 16px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .modal-header h3 {
            margin: 0;
            color: rgb(19, 15, 64);
        }

        .close {
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: rgb(19, 15, 64);
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-group textarea {
            resize: vertical;
        }

        .choices-container {
            margin-bottom: 1.5rem;
        }

        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background: rgb(19, 15, 64);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: rgb(59, 54, 140);
        }
    </style>

    <script>
        function showEditQuestionModal(questionId) {
            // Implement edit modal functionality
            alert('Edit question ' + questionId);
        }
    </script>
@endsection
