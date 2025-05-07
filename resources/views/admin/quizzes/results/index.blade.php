<x-app-layout>
    <x-slot name="header">
        <h2>
            Results for {{ $quiz->title }}
        </h2>
    </x-slot>

    <div>
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th @click="sortBy('name')">User</th>
                    <th @click="sortBy('category')">Category</th>
                    <th @click="sortBy('score')">Total Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizUsers as $quizUser)
                    <tr>
                        <td><input type="checkbox" name="selected_users[]" value="{{ $quizUser->id }}"></td>
                        <td>{{ $quizUser->user->name }}</td>
                        <td>{{ $quizUser->category->name }}</td>
                        <td>{{ $quizUser->total_score ?? 'Pending' }}</td>
                        <td>
                            <a href="{{ route('admin.quizzes.results.show', [$quiz, $quizUser]) }}">View Details</a>
                            <form method="POST"
                                action="{{ route('admin.quizzes.results.toggle-visibility', [$quiz, $quizUser]) }}"
                                style="display:inline;">
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
