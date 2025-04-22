<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Edit Question') }}</h2>
    </x-slot>

    <form method="POST" action="{{ route('admin.questions.update', $question) }}">
        @csrf
        @method('PATCH')

        <div>
            <label for="question_type">{{ __('Question Type') }}</label>
            <select name="question_type" required>
                <option value="text" {{ $question->question_type === 'text' ? 'selected' : '' }}>Text</option>
                <option value="image" {{ $question->question_type === 'image' ? 'selected' : '' }}>Image</option>
            </select>
        </div>

        <div>
            <label for="question_content">{{ __('Question Content') }}</label>
            <textarea name="question_content" required>{{ old('question_content', $question->question_content) }}</textarea>
            <x-input-error :messages="$errors->get('question_content')" />
        </div>

        <h3>{{ __('Choices') }}</h3>
        @foreach ($question->choices as $index => $choice)
            <div>
                <label>{{ __('Choice') }} {{ $index + 1 }}</label>
                <input type="text" name="choices[{{ $index }}][choice_content]"
                    value="{{ $choice->choice_content }}" required />
                <select name="choices[{{ $index }}][choice_type]" required>
                    <option value="text" {{ $choice->choice_type === 'text' ? 'selected' : '' }}>Text</option>
                    <option value="image" {{ $choice->choice_type === 'image' ? 'selected' : '' }}>Image</option>
                </select>
            </div>
        @endforeach

        <div>
            <label for="correct_choice_index">{{ __('Correct Answer Index (0-3)') }}</label>
            <input type="number" name="correct_choice_index"
                value="{{ $question->choices->search(fn($c) => $c->is_correct) }}" min="0" max="3"
                required />
            <x-input-error :messages="$errors->get('correct_choice_index')" />
        </div>

        <button type="submit">{{ __('Update Question') }}</button>
    </form>
</x-app-layout>
