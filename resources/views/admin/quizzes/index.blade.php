<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">{{ __('Quizzes') }}</h2>
    </x-slot>

    @php
        $showPosted = request('show_posted', '0') === '1';
    @endphp

    <div>
        <form method="GET" style="display:inline-block;">
            <input type="hidden" name="show_posted" value="0">
            <button type="submit" class="admin-toggle-btn{{ !$showPosted ? ' active' : '' }}">Unposted</button>
        </form>
        <form method="GET" style="display:inline-block;">
            <input type="hidden" name="show_posted" value="1">
            <button type="submit" class="admin-toggle-btn{{ $showPosted ? ' active' : '' }}">Posted</button>
        </form>
    </div>

    <div x-data="{ showAddQuizForm: false }">
        @if (!$showPosted)
            {{-- Toggle button --}}
            <button @click="showAddQuizForm = !showAddQuizForm" class="admin-action-btn secondary">
                + Add Quiz
            </button>
            {{-- Modal. Partial: quiz-form.blade.php --}}
            <div x-show="showAddQuizForm">
                @include('admin.quizzes.partials.quiz-form', [
                    'action' => route('admin.quizzes.store'),
                    'method' => 'POST',
                ])
            </div>
        @endif
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
                            <td>{{ $quiz->timer ? $quiz->timer . 's' : 'None' }}</td>
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
                                    <button @click="showEditQuizForm = !showEditQuizForm" class="admin-action-btn secondary">
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
                            <td x-show="showEditQuizForm">
                                @include('admin.quizzes.partials.quiz-form', [
                                    'quiz' => $quiz,
                                    'action' => route('admin.quizzes.update', $quiz),
                                    'method' => 'PATCH',
                                ])
                            </td>
                        </tr>
                    </tbody>
                @endif
            @endforeach
        </table>
    </div>
</x-app-layout>
