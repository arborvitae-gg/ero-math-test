<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quizzes') }}</h2>
    </x-slot>

    <div x-data="{ showCreate: false }">
        <!-- Add Quiz Button -->
        <div>
            <button @click="showCreate = !showCreate">
                + Add Quiz Popup Modal Toggle
            </button>
        </div>

        <!-- Modal Add Form -->
        <div x-show="showCreate">
            @include('admin.partials.quiz-form', [
                'action' => route('admin.quizzes.store'),
                'method' => 'POST',
            ])
        </div>

        <!-- Quiz Table -->
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Timer</th>
                        <th>Status</th>
                        <th>Questions</th>
                        <th></th>
                    </tr>
                </thead>
                @foreach ($quizzes as $quiz)
                    <tbody x-data="{ edit: false }">
                        <tr>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ $quiz->timer ? $quiz->timer . 's' : 'None' }}</td>
                            <td>{{ $quiz->is_posted ? 'Posted' : 'Unposted' }}</td>
                            <td>
                                @foreach ($categories as $cat)
                                    {{ $cat->name }}:
                                    {{ $quiz->questions->where('category_id', $cat->id)->count() }}<br>
                                @endforeach
                            </td>
                            <td>
                                {{-- added line break on line 48 for better UI placement, remove when styling --}}
                                <a href="{{ route('admin.quizzes.questions.index', $quiz) }}">View</a><br>
                                <button @click="edit = !edit">
                                    Edit Popup Modal Toggle
                                </button>
                                <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr x-show="edit" class="bg-gray-50">
                            <td colspan="5">
                                @include('admin.partials.quiz-form', [
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
