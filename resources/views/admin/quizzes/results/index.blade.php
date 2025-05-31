{{-- Remove the default header slot title --}}
{{-- <x-slot name="header">
    <h2>{{ $quiz->title }} {{ __(' Results') }}</h2>
</x-slot> --}}

<x-app-layout>
    <x-slot name="header">
        <div class="results-header-center">
            <h2>{{ $quiz->title }} {{ __(' Results') }}</h2>
        </div>
    </x-slot>

    <div class="results-back-link-container">
        <a href="{{ route('admin.quizzes.index') }}" class="results-back-link">&larr; Back to Quizzes</a>
    </div>

    <div class="results-table-container">
        {{-- Remove the results-title from inside the container --}}
        {{-- <h2 class="results-title">{{ $quiz->title }} <span>Results</span></h2> --}}
        <table class="results-table">
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
            <tbody>
                @foreach ($quizUsers as $quizUser)
                    <tr>
                        <td>{{ $quizUser->user->first_name . ' ' . $quizUser->user->last_name }}</td>
                        <td>{{ $quizUser->category->name }}</td>
                        <td>{{ $quizUser->total_score }}</td>
                        <td>{{ $quiz->questions->where('category_id', $quizUser->category_id)->count() }}</td>
                        <td>
                        <td>{{ $quizUser->started_at ? $quizUser->started_at->format('Y-m-d H:i:s') : '-' }}</td>
                        <td>{{ $quizUser->completed_at ? $quizUser->completed_at->format('Y-m-d H:i:s') : '-' }}
                        </td>
                        <td>
                            <x-duration-display :start="$quizUser->started_at" :end="$quizUser->completed_at" />
                        </td>
                        <a href="{{ route('admin.quizzes.results.show', [$quiz, $quizUser]) }}"
                            class="results-view-link">View Results</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
