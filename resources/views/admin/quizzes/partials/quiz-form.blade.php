@props(['quiz' => null, 'action', 'method'])

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PATCH')
        @method('PATCH')
    @endif

    <div>
        <label for="title">Title</label>
        <input name="title" type="text" required value="{{ old('title', $quiz->title ?? '') }}" />
    </div>

    <div>
        <label for="timer">Timer (in seconds)</label>
        <input name="timer" type="number" value="{{ old('timer', $quiz->timer ?? '') }}" />
    </div>

    <div>
        <label>
            {{-- is_posted checks if the quiz will be accessible by normal users  --}}
            <input type="checkbox" name="is_posted" value="1"
                {{ old('is_posted', $quiz->is_posted ?? false) ? 'checked' : '' }} />
            Post Now?
        </label>
    </div>

    <button type="submit">
        {{ $method === 'PATCH' ? 'Update' : 'Save' }}
    </button>
</form>
