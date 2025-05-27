@props(['quiz' => null, 'action', 'method'])

@php
    $timer = old('timer', $quiz->timer ?? 0);
    $timer_h = floor($timer / 3600);
    $timer_m = floor(($timer % 3600) / 60);
    $timer_s = $timer % 60;
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PATCH')
        @method('PATCH')
    @endif
    <div>
        <div>
            <label for="title">Title</label>
            <input id="quiz-input" name="title" type="text" required value="{{ old('title', $quiz->title ?? '') }}" />
        </div>

        <div>
            <label>Timer</label>
            <div>
                {{-- hours --}}
                <input name="timer_h" type="number" min="0" max="23" value="{{ old('timer_h', $timer_h) }}"
                    placeholder="hh" />

                <span>:</span>

                {{-- minutes --}}
                <input name="timer_m" type="number" min="0" max="59"
                    value="{{ old('timer_m', $timer_m) }}" placeholder="mm" />

                <span>:</span>

                {{-- seconds --}}
                <input name="timer_s" type="number" min="0" max="59"
                    value="{{ old('timer_s', $timer_s) }}" placeholder="ss" />
            </div>
        </div>

        <button type="submit">
            {{ $method === 'PATCH' ? 'Update' : 'Save' }}
        </button>
    </div>
</form>
