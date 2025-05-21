@props(['quiz' => null, 'action', 'method'])

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PATCH')
        @method('PATCH')
    @endif
<div class="quiz-modal-container">
    <div>
        <label for="title">Title</label>
        <input id="quiz-input" name="title" type="text" required value="{{ old('title', $quiz->title ?? '') }}" />
    </div>

    <div>
        <label for="timer">Timer (in seconds)</label>
        <input id="quiz-input" name="timer" type="number" value="{{ old('timer', $quiz->timer ?? '') }}" />
    </div>

    <button type="submit">
        {{ $method === 'PATCH' ? 'Update' : 'Save' }}
    </button>
</div>
</form>
