@props(['question' => null, 'action', 'method'])

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PATCH')
        @method('PATCH')
    @endif

    @if ($question)
        <input type="hidden" name="category_id" value="{{ $question->category_id }}">
    @else
        <input type="hidden" name="category_id" :value="categoryId" />
    @endif

    <!-- Question -->
    <div>
        <label>Question Content</label>
        <textarea name="question_content" required>{{ old('question_content', $question->question_content ?? '') }}</textarea>
        <select name="question_type" required>
            <option value="text"
                {{ old('question_type', $question->question_type ?? '') == 'text' ? 'selected' : '' }}>Text</option>
            <option value="image"
                {{ old('question_type', $question->question_type ?? '') == 'image' ? 'selected' : '' }}>Image</option>
        </select>
    </div>

    <!-- Correct Choice -->
    <div>
        <h4>Correct Choice</h4>
        <input name="choices[0][choice_content]"
            value="{{ old('choices.0.choice_content', $question->choices[0]->choice_content ?? '') }}" required />
        <select name="choices[0][choice_type]" required>
            <option value="text"
                {{ old('choices.0.choice_type', $question->choices[0]->choice_type ?? '') == 'text' ? 'selected' : '' }}>
                Text</option>
            <option value="image"
                {{ old('choices.0.choice_type', $question->choices[0]->choice_type ?? '') == 'image' ? 'selected' : '' }}>
                Image</option>
        </select>
    </div>

    <!-- Other Choices -->
    <div>
        <h4>Other Choices</h4>
        @for ($i = 1; $i < 4; $i++)
            @php
                $choice = $question->choices[$i] ?? null;
            @endphp
            <div>
                <input name="choices[{{ $i }}][choice_content]"
                    value="{{ old("choices.$i.choice_content", $choice->choice_content ?? '') }}" required />
                <select name="choices[{{ $i }}][choice_type]" required>
                    <option value="text"
                        {{ old("choices.$i.choice_type", $choice->choice_type ?? '') == 'text' ? 'selected' : '' }}>
                        Text</option>
                    <option value="image"
                        {{ old("choices.$i.choice_type", $choice->choice_type ?? '') == 'image' ? 'selected' : '' }}>
                        Image</option>
                </select>
            </div>
        @endfor
    </div>

    <button type="submit">
        {{ $method === 'PATCH' ? 'Update' : 'Save' }}
    </button>
</form>
