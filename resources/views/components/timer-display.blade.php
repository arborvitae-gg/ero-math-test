<?php
// resources/views/components/timer-display.blade.php

/**
 * Usage: <x-timer-display :seconds="$quiz->timer" />
 * Displays timer in h m s format, or 'No Timer' if 0/null.
 */
?>
@if (isset($seconds) && $seconds)
    @php
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        $timerDisplay = ($hours > 0 ? $hours . 'h ' : '') . ($minutes > 0 ? $minutes . 'm ' : '');
        if ($secs > 0 || ($hours === 0 && $minutes === 0)) {
            $timerDisplay .= $secs . 's';
        }
        $timerDisplay = trim($timerDisplay);
    @endphp
    {{ $timerDisplay }}
@else
    No Timer
@endif
