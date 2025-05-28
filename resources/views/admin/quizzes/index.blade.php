<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quizzes') }}</h2>
    </x-slot>

    <div x-data="{ showAddQuizForm: false }">

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

        {{-- List of quizzes table --}}


        <table>
            {{-- thead = table head --}}
            <div>
                <thead>
                    <tr>
                        <th>Quiz Title</th>
                        <th>Timer</th>
                        <th>Status</th>
                        <th>No. of Questions</th>
                        <th></th> {{-- Empty header for actions --}}
                    </tr>
                </thead>
            </div>

            {{-- foreach loops through all the quizzes in the database --}}
            @foreach ($quizzes as $quiz)
                {{-- tbody = table body --}}
                <div>
                    <tbody x-data="{ showEditQuizForm: false }">
                        <tr>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ $quiz->timer ? $quiz->timer . 's' : 'None' }}</td>
                            <td>{{ $quiz->is_posted ? 'Posted' : 'Unposted' }}</td>
                            <td>
                                {{-- lists number of questions per category --}}
                                @foreach ($categories as $cat)
                                    {{ $cat->name }}:
                                    {{ $quiz->questions->where('category_id', $cat->id)->count() }}<br>
                                @endforeach
                            </td>
                            <td>
                                @if ($quiz->is_posted)
                                    {{-- If posted: show Results/Delete? --}}
                                    <a href="{{ route('admin.quizzes.results.index', $quiz) }}">View Quiz Results</a>
                                @else
                                    {{-- If not posted: show Edit/Delete/Post --}}

                                    <a href="{{ route('admin.quizzes.questions.index', $quiz) }}">
                                        Add/Edit Questions
                                    </a>

                                    <br>

                                    {{-- Toggle button: Edit --}}

                                    <button @click="showEditQuizForm = !showEditQuizForm">
                                        Edit Quiz
                                    </button>

                                    {{-- Post Quiz button --}}
                                    <form method="POST" action="{{ route('admin.quizzes.post', $quiz) }}"
                                        onsubmit="return confirm('Posting this quiz will prevent future edits or deletion. Are you sure?');">
                                        @csrf
                                        <button type="submit">Post Quiz</button>
                                    </form>
                                @endif

                                {{-- Delete quiz form and button --}}
                                <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete Quiz</button>
                                </form>
                            </td>

                            {{-- Modal. Partial: quiz-form.blade.php --}}
                            <td x-show="showEditQuizForm">
                                @include('admin.quizzes.partials.quiz-form', [
                                    'quiz' => $quiz,
                                    'action' => route('admin.quizzes.update', $quiz),
                                    'method' => 'PATCH',
                                ])
                            </td>
                        </tr>
                    </tbody>
                </div>
            @endforeach

        </table>

    </div>
</x-app-layout>
