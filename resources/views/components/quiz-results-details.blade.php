{{-- resources/views/components/quiz-results-details.blade.php --}}
<div x-data="{ order: 'admin' }">
    {{-- User info and score --}}
    <div class="quiz-results-meta-row">
        @if (!isset($hideUser) || !$hideUser)
            <div class="quiz-results-meta-col">
                <div class="quiz-results-meta-label">User:</div>
                <div class="quiz-results-meta-value">{{ $quizUser->user->first_name . ' ' . $quizUser->user->last_name }}</div>
            </div>
        @endif
        <div class="quiz-results-meta-col">
            <div class="quiz-results-meta-label">Category:</div>
            <div class="quiz-results-meta-value">{{ $quizUser->category->name }}</div>
        </div>
        <div class="quiz-results-meta-col">
            <div class="quiz-results-meta-label">Score:</div>
            <div class="quiz-results-meta-value quiz-results-score-row">
                {{ $quizUser->attempts->where('is_correct', true)->count() }}
                /
                {{ $quizUser->attempts->count() }}
            </div>
        </div>
        
        <h3>Attempt Duration:</h3>
        <div class="quiz-results-score">
            <x-duration-display :start="$quizUser->started_at" :end="$quizUser->completed_at" />
        </div>
    </div>

    <div class="quiz-results-order-toggle">
        <button type="button" @click="order = 'admin'" :class="order === 'admin' ? 'active' : ''">Default Order
        </button>
        <button type="button" @click="order = 'user'" :class="order === 'user' ? 'active' : ''">User's Randomized
            Order
        </button>
    </div>

    @php
        $userCategoryId = $quizUser->category_id;
    @endphp

    <div x-show="order === 'admin'">
        @include('components.quiz-results-admin-order', compact('quizUser', 'userCategoryId'))
    </div>
    <div x-show="order === 'user'">
        @include('components.quiz-results-random-order', compact('quizUser', 'userCategoryId'))
    </div>
</div>
