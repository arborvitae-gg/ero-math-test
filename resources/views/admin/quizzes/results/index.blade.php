<x-app-layout>
    <x-slot name="header">
        <h2>Results for {{ $quiz->title }}</h2>
    </x-slot>

    <div>
        @include('admin.quizzes.results.partials.toggle-all-form', ['quiz' => $quiz])
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Category</th>
                    <th>Total Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizUsers as $quizUser)
                    <tr>
                        <td>{{ $quizUser->user->name ?? $quizUser->user->first_name . ' ' . $quizUser->user->last_name }}
                        </td>
                        <td>{{ $quizUser->category->name }}</td>
                        <td>{{ $quizUser->total_score ?? 'Pending' }}</td>
                        <td>
                            <a href="{{ route('admin.quizzes.results.show', [$quiz, $quizUser]) }}">View Details</a>
                            <form method="POST"
                                action="{{ route('admin.quizzes.results.toggle-visibility', [$quiz, $quizUser]) }}">
                                @csrf
                                <button type="submit">
                                    {{ $quizUser->can_view_score ? 'Revoke User Access' : 'Allow User to View Score' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
