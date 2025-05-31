{{-- resources/views/components/duration-display.blade.php --}}
@props(['start', 'end'])

@php
    $display = '-';
    if ($start && $end) {
        $duration = $end->diff($start);
        $parts = [];
        if ($duration->h > 0) {
            $parts[] = $duration->h . 'h';
        }
        if ($duration->i > 0) {
            $parts[] = $duration->i . 'm';
        }
        $parts[] = $duration->s . 's';
        $display = trim(implode(' ', $parts));
    }
@endphp
{{ $display }}
