<x-app-layout>
    <x-slot name="header">
        <h2>{{ $quiz->title }} {{ __(' Results') }}</h2>
    </x-slot>

    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.quizzes.index') }}">
            &larr; Back to Quizzes</a> {{-- &larr: back arrow --}}
    </div>

    <div>
        <table>
            <div>
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Category</th>
                        <th>Score</th>
                        <th>Total Questions</th>
                        <th>Started At</th>
                        <th>Completed At</th>
                        <th>Duration</th>
                        <th></th> {{-- Empty header for action links --}}
                    </tr>
                </thead>
            </div>

            <div>
                <tbody>
                    @foreach ($quizUsers as $quizUser)
                        <tr>
                            <td>{{ $quizUser->user->first_name . ' ' . $quizUser->user->last_name }}
                            </td>
                            <td>{{ $quizUser->category->name }}</td>
                            <td>{{ $quizUser->total_score }}</td>
                            <td>{{ $quiz->questions->where('category_id', $quizUser->category_id)->count() }}</td>
                            <td>{{ $quizUser->started_at ? $quizUser->started_at->format('Y-m-d H:i:s') : '-' }}</td>
                            <td>{{ $quizUser->completed_at ? $quizUser->completed_at->format('Y-m-d H:i:s') : '-' }}
                            </td>
                            <td>
                                <x-duration-display :start="$quizUser->started_at" :end="$quizUser->completed_at" />
                            </td>
                            <td>
                                <a href="{{ route('admin.quizzes.results.show', [$quiz, $quizUser]) }}">View Results</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </div>
        </table>
    </div>
</x-app-layout>
