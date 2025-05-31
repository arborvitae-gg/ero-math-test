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

    <label for="title">Title</label>
    <input id="quiz-input" name="title" type="text" required value="{{ old('title', $quiz->title ?? '') }}" />

    <label>Timer</label>
    <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 1.2rem; justify-content: center;">
        <input name="timer_h" type="number" min="0" max="23" value="{{ old('timer_h', $timer_h) }}"
            placeholder="hh" style="width: 64px; padding: 0.5rem; border: 1.5px solid #bfc9e0; border-radius: 7px; font-size: 1.2rem; text-align: center; background: #f8fafc; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#1976d2'" onblur="this.style.borderColor='#bfc9e0'" />
        <span style="font-size: 1.2rem; color: #888;">:</span>
        <input name="timer_m" type="number" min="0" max="59" value="{{ old('timer_m', $timer_m) }}"
            placeholder="mm" style="width: 64px; padding: 0.5rem; border: 1.5px solid #bfc9e0; border-radius: 7px; font-size: 1.2rem; text-align: center; background: #f8fafc; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#1976d2'" onblur="this.style.borderColor='#bfc9e0'" />
        <span style="font-size: 1.2rem; color: #888;">:</span>
        <input name="timer_s" type="number" min="0" max="59" value="{{ old('timer_s', $timer_s) }}"
            placeholder="ss" style="width: 64px; padding: 0.5rem; border: 1.5px solid #bfc9e0; border-radius: 7px; font-size: 1.2rem; text-align: center; background: #f8fafc; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#1976d2'" onblur="this.style.borderColor='#bfc9e0'" />
    </div>

    <button type="submit">
        {{ $method === 'PATCH' ? 'Update' : 'Save' }}
    </button>

</form>
