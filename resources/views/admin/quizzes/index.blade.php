<x-app-layout x-data="{ showAddQuizForm: false }">
    <x-slot name="header">
        <h2 class="dashboard-title">{{ __('Quizzes') }}</h2>
    </x-slot>

    @php
        $showPosted = request('show_posted', '0') === '1';
    @endphp

    <style>
        .admin-main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        .admin-center-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .admin-table {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }
    </style>

    <div class="admin-main-container" x-data="{ showAddQuizForm: false }">
        <div class="admin-center-controls">
            <form method="GET" style="display:inline-block;">
                <input type="hidden" name="show_posted" value="0">
                <button type="submit" class="admin-toggle-btn{{ !$showPosted ? ' active' : '' }}">Unposted</button>
            </form>
            <form method="GET" style="display:inline-block;">
                <input type="hidden" name="show_posted" value="1">
                <button type="submit" class="admin-toggle-btn{{ $showPosted ? ' active' : '' }}">Posted</button>
            </form>
            <button @click="showAddQuizForm = true" class="admin-action-btn secondary" style="margin-left: 1rem;">+ Add Quiz</button>
        </div>
        <!-- Modal Popup for Add Quiz (inside main container, left-aligned but functional) -->
        <div x-show="showAddQuizForm"
            @click.self="showAddQuizForm = false"
            style="position: fixed; inset: 0; z-index: 1001; display: flex; align-items: flex-start; justify-content: flex-start; background: rgba(20,30,60,0.35); backdrop-filter: blur(1.5px);"
            x-cloak>
            <div @click.away="showAddQuizForm = false" style="background: #fff; border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.25); padding: 2.5rem 2rem 2rem 2rem; min-width: 320px; max-width: 420px; width: 100%; position: relative; z-index: 1002; display: flex; flex-direction: column; align-items: stretch; margin: 2rem auto auto 2rem;">
                <button @click="showAddQuizForm = false" style="position: absolute; top: 1.1rem; right: 1.1rem; background: none; border: none; font-size: 2rem; color: #888; cursor: pointer; transition: color 0.2s;" @mouseover="$el.style.color='#1976d2'" @mouseleave="$el.style.color='#888'">&times;</button>
                <h3 style="margin-bottom: 1.5rem; text-align: center; font-size: 1.35rem; font-weight: 600; color: #1a237e; letter-spacing: 0.01em;">Create New Quiz</h3>
                @include('admin.quizzes.partials.quiz-form', [
                    'action' => route('admin.quizzes.store'),
                    'method' => 'POST',
                ])
            </div>
        </div>
        {{-- List of quizzes table --}}
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Quiz Title</th>
                    <th>Timer</th>
                    <th>No. of Questions</th>
                    <th></th> {{-- Empty header for actions --}}
                </tr>
            </thead>
            @foreach ($quizzes as $quiz)
                @php
                    $isPosted = $quiz->is_posted;
                @endphp
                @if (($showPosted && $isPosted) || (!$showPosted && !$isPosted))
                    <tbody x-data="{ showEditQuizForm: false }">
                        <tr>
                            <td>{{ $quiz->title }}</td>
                            <td>
                                <x-timer-display :seconds="$quiz->timer" />
                            </td>
                            <td>
                                @foreach ($categories as $cat)
                                    {{ $cat->name }}:
                                    {{ $quiz->questions->where('category_id', $cat->id)->count() }}<br>
                                @endforeach
                            </td>
                            <td>
                                @if ($quiz->is_posted)
                                    <a href="{{ route('admin.quizzes.questions.index', $quiz) }}" class="admin-action-btn secondary">
                                        Review Questions
                                    </a>
                                    <br>
                                    <a href="{{ route('admin.quizzes.results.index', $quiz) }}" class="admin-action-btn secondary">View User Results</a>
                                @else
                                    <a href="{{ route('admin.quizzes.questions.index', $quiz) }}" class="admin-action-btn secondary">
                                        Manage Questions
                                    </a>
                                    <br>
                                    <button @click="showEditQuizForm = true" class="admin-action-btn secondary">
                                        Edit Quiz
                                    </button>
                                    <form method="POST" action="{{ route('admin.quizzes.post', $quiz) }}"
                                        onsubmit="return confirm('Posting this quiz will prevent future edits or deletion. Are you sure?');" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="admin-action-btn">Post Quiz</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this quiz? If the quiz is already posted, it will also delete all recorded quiz attempts/scores/data.');" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-action-btn danger">Delete Quiz</button>
                                </form>
                            </td>
                            <!-- Edit Quiz Modal Popup -->
                            <td style="position: relative;">
                                <div x-show="showEditQuizForm"
                                    style="position: fixed; inset: 0; z-index: 1001; display: flex; align-items: center; justify-content: center; background: rgba(20,30,60,0.35); backdrop-filter: blur(1.5px);"
                                    x-cloak>
                                    <div @click.away="showEditQuizForm = false" style="background: #fff; border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.25); padding: 2.5rem 2rem 2rem 2rem; min-width: 320px; max-width: 420px; width: 100%; position: relative; z-index: 1002; display: flex; flex-direction: column; align-items: stretch;">
                                        <button @click="showEditQuizForm = false" style="position: absolute; top: 1.1rem; right: 1.1rem; background: none; border: none; font-size: 2rem; color: #888; cursor: pointer; transition: color 0.2s;" @mouseover="$el.style.color='#1976d2'" @mouseleave="$el.style.color='#888'">&times;</button>
                                        <h3 style="margin-bottom: 1.5rem; text-align: center; font-size: 1.35rem; font-weight: 600; color: #1a237e; letter-spacing: 0.01em;">Edit Quiz</h3>
                                        @include('admin.quizzes.partials.quiz-form', [
                                            'quiz' => $quiz,
                                            'action' => route('admin.quizzes.update', $quiz),
                                            'method' => 'PATCH',
                                        ])
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @endif
            @endforeach
        </table>
    </div>
</x-app-layout>
