{{-- resources/views/components/quiz-results-details.blade.php --}}
<div x-data="{ order: 'admin' }">

    {{-- User info and score --}}
    <div>
        @if (!isset($hideUser) || !$hideUser)
            <h3>User: </h3>
            <p>{{ $quizUser->user->first_name . ' ' . $quizUser->user->last_name }}</p>
        @endif

        <h3>Category: </h3>
        <p>{{ $quizUser->category->name }}</p>

        <h3>Score:</h3>
        <p>
            {{ $quizUser->attempts->where('is_correct', true)->count() }}
            /
            {{ $quizUser->attempts->count() }}
        </p>
    </div>

    <div style="margin-bottom: 1em;">
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
