<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quizzes') }}</h2>
    </x-slot>


    <div x-data="{ showCreate: false }">

        {{-- Toggleable Pop-up modal Add Quiz button --}}
        <div>
            <button @click="showCreate = !showCreate">
                + Add Quiz Popup Modal Toggle
            </button>
        </div>

        {{-- Model add quiz form, form blade file located in views/admin/partials/quiz-form.blade.php --}}
        <div x-show="showCreate">
            @include('admin.quizzes.partials.quiz-form', [
                'action' => route('admin.quizzes.store'),
                'method' => 'POST',
            ])
        </div>

        {{-- List of quizzes table --}}
        <div>
            <table>
                {{-- thead = table head --}}
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Timer</th>
                        <th>Status</th>
                        <th>Questions</th>
                        <th></th>
                    </tr>
                </thead>

                {{-- foreach loops through all the quizzes in the database --}}
                @foreach ($quizzes as $quiz)
                    {{-- tbody = table body --}}
                    <tbody x-data="{ edit: false }">
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
                                {{-- added line break on line 48 for better UI placement, remove when styling --}}
                                <a href="{{ route('admin.quizzes.questions.index', $quiz) }}">Quiz Questions</a><br>

                                @if ($quiz->is_posted)
                                    {{-- If posted: show Results only --}}
                                    <a href="{{ route('admin.quizzes.results.index', $quiz) }}">Quiz Results</a>
                                    <p><em>This quiz is posted and locked.</em></p>
                                @else
                                    {{-- If not posted: show Edit/Delete/Post --}}

                                    {{-- Toggleable Pop-up modal Edit Quiz button (form below the delete quiz button) --}}
                                    <button @click="edit = !edit">
                                        Edit Quiz
                                    </button>

                                    {{-- Delete quiz form and button --}}
                                    <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete Quiz</button>
                                    </form>

                                    {{-- Post Quiz button --}}
                                    <form method="POST" action="{{ route('admin.quizzes.post', $quiz) }}"
                                        onsubmit="return confirm('Posting this quiz will prevent future edits or deletion. Are you sure?');">
                                        @csrf
                                        <button type="submit">Post Quiz</button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        {{-- Model edit quiz form, form blade file located in views/admin/partials/quiz-form.blade.php --}}
                        <tr x-show="edit">
                            <td>
                                @include('admin.quizzes.partials.quiz-form', [
                                    'quiz' => $quiz,
                                    'action' => route('admin.quizzes.update', $quiz),
                                    'method' => 'PATCH',
                                ])
                            </td>
                        </tr>

                    </tbody>
                @endforeach

            </table>
        </div>
    </div>
</x-app-layout>
