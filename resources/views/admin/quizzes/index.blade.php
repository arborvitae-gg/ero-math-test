@extends('layouts.app')

@section('content')
    <div class="quizzes-container">
        <div class="quizzes-header">
            <h2>Quiz Management</h2>
            <p>Create and manage quizzes for users</p>
            <button class="add-quiz-btn" onclick="document.getElementById('createQuizModal').style.display='block'">
                <i class="fa-solid fa-plus"></i>
                Add New Quiz
            </button>
        </div>

        <div class="quizzes-grid">
            @foreach ($quizzes as $quiz)
                <div class="quiz-card">
                    <div class="quiz-header">
                        <h3>{{ $quiz->title }}</h3>
                        <span class="status-badge {{ $quiz->is_posted ? 'posted' : 'draft' }}">
                            {{ $quiz->is_posted ? 'Posted' : 'Draft' }}
                        </span>
                    </div>

                    <div class="quiz-meta">
                        <div class="meta-item">
                            <i class="fa-solid fa-clock"></i>
                            {{ $quiz->timer ? $quiz->timer . 's' : 'No Timer' }}
                        </div>
                        <div class="meta-item">
                            <i class="fa-solid fa-question"></i>
                            {{ $quiz->questions_count ?? 0 }} Questions
                        </div>
                    </div>

                    <div class="quiz-actions">
                        @if ($quiz->is_posted)
                            <a href="{{ route('admin.quizzes.results.index', $quiz) }}" class="action-btn results">
                                <i class="fa-solid fa-chart-simple"></i>
                                View Results
                            </a>
                        @else
                            <a href="{{ route('admin.quizzes.questions.index', $quiz) }}" class="action-btn questions">
                                <i class="fa-solid fa-list-check"></i>
                                Manage Questions
                            </a>
                            <button class="action-btn edit" onclick="showEditQuizModal({{ $quiz->id }})">
                                <i class="fa-solid fa-pen"></i>
                                Edit Quiz
                            </button>
                            <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this quiz?');"
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete">
                                    <i class="fa-solid fa-trash"></i>
                                    Delete
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.quizzes.post', $quiz) }}"
                                  onsubmit="return confirm('Posting this quiz will prevent future edits or deletion. Are you sure?');"
                                  style="display: inline;">
                                @csrf
                                <button type="submit" class="action-btn post">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    Post Quiz
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Create Quiz Modal -->
    <div id="createQuizModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New Quiz</h3>
                <span class="close" onclick="document.getElementById('createQuizModal').style.display='none'">&times;</span>
            </div>
            <form method="POST" action="{{ route('admin.quizzes.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Quiz Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="timer">Time Limit (seconds)</label>
                    <input type="number" id="timer" name="timer" min="0">
                    <small>Leave empty for no time limit</small>
                </div>
                <button type="submit" class="submit-btn">Create Quiz</button>
            </form>
        </div>
    </div>

    <style>
        .quizzes-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .quizzes-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .quizzes-header h2 {
            font-size: 2rem;
            color: rgb(19, 15, 64);
            margin: 0;
        }

        .add-quiz-btn {
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

        .add-quiz-btn:hover {
            background: rgb(59, 54, 140);
        }

        .quizzes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .quiz-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
        }

        .quiz-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .quiz-header h3 {
            font-size: 1.25rem;
            color: white;
            margin: 0;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.posted {
            background: rgb(220, 252, 231);
            color: rgb(22, 101, 52);
        }

        .status-badge.draft {
            background: rgb(254, 243, 199);
            color: rgb(146, 64, 14);
        }

        .quiz-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            font-size: 0.875rem;
        }

        .quiz-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: none;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .action-btn.questions {
            background: rgb(224, 231, 255);
            color: rgb(40, 70, 199);
        }

        .action-btn.edit {
            background: rgb(254, 243, 199);
            color: rgb(146, 64, 14);
        }

        .action-btn.delete {
            background: rgb(254, 226, 226);
            color: rgb(185, 28, 28);
        }

        .action-btn.post {
            background: rgb(220, 252, 231);
            color: rgb(22, 101, 52);
        }

        .action-btn.results {
            background: rgb(224, 231, 255);
            color: rgb(40, 70, 199);
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
            margin: 10% auto;
            padding: 2rem;
            width: 90%;
            max-width: 500px;
            border-radius: 16px;
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

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-group small {
            display: block;
            margin-top: 0.25rem;
            color: #666;
            font-size: 0.875rem;
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
        function showEditQuizModal(quizId) {
            // Implement edit modal functionality
            alert('Edit quiz ' + quizId);
        }
    </script>
@endsection
