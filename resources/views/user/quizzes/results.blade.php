<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">{{ __('Results for: ') }} {{ $quiz->title }}</h2>
    </x-slot>

    <div class="dashboard-card" style="text-align:left; max-width: 700px;">
        {{-- Back Button --}}
        <div style="margin-bottom: 1.2rem;">
            <a href="{{ route('user.dashboard') }}" class="dashboard-btn secondary" style="max-width:220px;display:inline-block;">&larr; Back to Dashboard</a>
        </div>

        {{-- User Details --}}
        @include('components.quiz-results-details', ['hideUser' => true])
    </div>
</x-app-layout>
