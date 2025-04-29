<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz Results') }}</h2>
    </x-slot>

    <div>
        @foreach ($attempts as $attempt)
            <div>
                <h3>{{ $attempt->question->question_content }}</h3>

                <p>Your answer: {{ $attempt->selectedChoice->choice_content }}</p>

                @if ($attempt->is_correct)
                    <p>Correct!</p>
                @else
                    <p>Incorrect.</p>
                @endif
            </div>
            <hr>
        @endforeach
    </div>

    <div>
        <a href="{{ route('user.dashboard') }}">Return to Dashboard</a>
    </div>
</x-app-layout>
