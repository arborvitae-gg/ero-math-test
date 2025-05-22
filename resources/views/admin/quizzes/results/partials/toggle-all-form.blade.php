<form method="POST" action="{{ route('admin.quizzes.results.toggle-bulk-visibility', $quiz) }}" class="mb-4">
    @csrf
    <button type="submit" name="action" value="toggle_all" class="btn btn-secondary">
        Toggle All Users
    </button>
</form>
