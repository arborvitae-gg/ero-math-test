@props(['question' => null, 'action', 'method', 'quiz' => null])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
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
    <h4>Question</h4>

    <div>
        <textarea name="question_text">{{ old('question_text', $question->question_text ?? '') }}</textarea>

        <input type="file" name="question_image" class="form-control">

        @if (!empty($question?->question_image_url))
            <img src="{{ $question->question_image_url }}" alt="Preview">
        @endif
    </div>

    <!-- Correct Choice -->
    @php
        $firstChoice = $question->choices[0] ?? null;
    @endphp

    <h4>Correct Choice</h4>
    <div>
        <input name="choices[0][choice_text]"
            value="{{ old('choices.0.choice_text', $firstChoice->choice_text ?? '') }}">

        <input type="file" name="choices[0][choice_image]" class="form-control">

        @if (!empty($firstChoice?->choice_image_url))
            <img src="{{ $firstChoice->choice_image_url }}" alt="Preview">
        @endif
    </div>


    <!-- Other Choices -->

    <h4>Other Choices</h4>
    @for ($i = 1; $i < 4; $i++)
        @php
            $choice = $question->choices[$i] ?? null;
        @endphp

        <div>
            <input name="choices[{{ $i }}][choice_text]"
                value="{{ old("choices.$i.choice_text", $choice->choice_text ?? '') }}">

            <input type="file" name="choices[{{ $i }}][choice_image]" class="form-control">

            @if (!empty($choice?->choice_image_url))
                <img src="{{ $choice->choice_image_url }}" alt="Preview">
            @endif
        </div>
    @endfor


    <button type="submit">
        {{ $method === 'PATCH' ? 'Update' : 'Save' }}
    </button>
</form>
