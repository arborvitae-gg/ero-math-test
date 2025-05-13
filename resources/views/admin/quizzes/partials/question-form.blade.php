@props(['question' => null, 'action', 'method'])

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PATCH')
        @method('PATCH')
    @endif

    @if ($quiz)
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
    @endif

    @if ($question)
        <input type="hidden" name="category_id" value="{{ $question->category_id }}">
    @else
        <input type="hidden" name="category_id" :value="categoryId" />
    @endif

    <!-- Question -->
    <div>
        <h4>Question Text</h4>
        <textarea name="question_text">{{ old('question_text', $question->question_text ?? '') }}</textarea>
    </div>
    <div>
        <h4>Question Image</h4>
        <input type="file" name="question_image">
        @if (!empty($question->question_image))
            <img src="{{ asset('storage/' . $question->question_image) }}" alt="Question image preview"
                style="max-height: 100px;">
        @endif
    </div>

    <!-- Correct Choice -->
    <div>
        <h4>Correct Choice</h4>
        <input name="choices[0][choice_text]" value="{{ old('choices.0.choice_text', $choice->choice_text ?? '') }}">
        <input type="file" name="choices[0][choice_image]">
        @if (!empty($choice->choice_image))
            <img src="{{ asset('storage/' . $choice->choice_image) }}" alt="Choice image preview"
                style="max-height: 80px;">
        @endif
    </div>

    <!-- Other Choices -->
    <div>
        <h4>Other Choices</h4>
        @for ($i = 1; $i < 4; $i++)
            @php
                $choice = $question->choices[$i] ?? null;
            @endphp
            <div>
                {{-- <h4>Choice {{ $i + 1 }}</h4> --}}
                <input name="choices[{{ $i }}][choice_text]"
                    value="{{ old("choices.$i.choice_text", $choice->choice_text ?? '') }}">
                <input type="file" name="choices[{{ $i }}][choice_image]">
                @if (!empty($choice->choice_image))
                    <img src="{{ asset('storage/' . $choice->choice_image) }}" alt="Choice image preview"
                        style="max-height: 80px;">
                @endif
            </div>
        @endfor
    </div>

    <button type="submit">
        {{ $method === 'PATCH' ? 'Update' : 'Save' }}
    </button>
</form>
