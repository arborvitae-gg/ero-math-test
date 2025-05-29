<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quizzes') }}</h2>
    </x-slot>

    @php
        $showPosted = request('show_posted', '0') === '1';
    @endphp

    <div>
        <form method="GET">
            <input type="hidden" name="show_posted" value="0">
            <button type="submit" {{ !$showPosted ? ' active' : '' }}">Unposted</button>
        </form>
        <form method="GET">
            <input type="hidden" name="show_posted" value="1">
            <button type="submit" {{ $showPosted ? ' active' : '' }}">Posted</button>
        </form>
    </div>

    <div x-data="{ showAddQuizForm: false }">
        @if (!$showPosted)
            {{-- Toggle button --}}
            <button @click="showAddQuizForm = !showAddQuizForm">
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
        <table>
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
                                    <a href="{{ route('admin.quizzes.questions.index', $quiz) }}">
                                        Review Questions
                                    </a>
                                    <br>
                                    <a href="{{ route('admin.quizzes.results.index', $quiz) }}">View Quiz Results</a>
                                @else
                                    <a href="{{ route('admin.quizzes.questions.index', $quiz) }}">
                                        Add/Edit Questions
                                    </a>
                                    <br>
                                    <button @click="showEditQuizForm = !showEditQuizForm">
                                        Edit Quiz
                                    </button>
                                    <form method="POST" action="{{ route('admin.quizzes.post', $quiz) }}"
                                        onsubmit="return confirm('Posting this quiz will prevent future edits or deletion. Are you sure?');">
                                        @csrf
                                        <button type="submit">Post Quiz</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this quiz? If the quiz is already posted, it will also delete all recorded quiz attempts/scores/data.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete Quiz</button>
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
