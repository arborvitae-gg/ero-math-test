<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">{{ __('Quiz Completed') }}</h2>
    </x-slot>

    <div class="dashboard-card" style="text-align:center;">
        <h3 style="font-size:1.5rem; color:#388e3c; font-weight:800; margin-bottom:0.7rem;">Congratulations!</h3>
        <p style="font-size:1.1rem; color:#444; margin-bottom:1.5rem;">
            You have successfully completed:<br>
            <span style="font-weight:600; color:#1976d2;">{{ $quizUser->quiz->title }}</span>
        </p>
        <div style="display:flex; gap:1rem; justify-content:center; margin-top:1.5rem; flex-wrap:wrap;">
            <a href="{{ route('user.dashboard') }}" class="dashboard-btn secondary">Back to Dashboard</a>
            <a href="{{ route('user.quizzes.attempts.results', [$quizUser->quiz, $quizUser]) }}" class="dashboard-btn">View Results</a>
        </div>
    </div>
</x-app-layout>
