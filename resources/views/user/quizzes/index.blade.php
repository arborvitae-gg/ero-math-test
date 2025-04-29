<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Available Quizzes') }}</h2>
    </x-slot>

    <div>
        @foreach ($quizzes as $quiz)
            <div>
                <h3>{{ $quiz->title }}</h3>
                <p>Timer: {{ $quiz->timer ? $quiz->timer . ' seconds' : 'No Timer' }}</p>
                <p>
                    Questions available:
                    @php
                        $userCategory = \App\Models\Category::findCategoryForGrade($user->grade_level);
                    @endphp

                    {{ $userCategory ? $quiz->questions->where('category_id', $userCategory->id)->count() : 0 }}
                </p>

                <form method="POST" action="{{ route('user.quizzes.start', $quiz) }}">
                    @csrf
                    <button type="submit">Start Quiz</button>
                </form>
            </div>
            <hr>
        @endforeach
    </div>
</x-app-layout>
