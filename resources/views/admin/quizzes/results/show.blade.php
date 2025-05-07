<x-app-layout>
    <x-slot name="header">
        <h2>
            Results for {{ $quizUser->user->name }} ({{ $quiz->title }})
        </h2>
    </x-slot>

    <div id="quiz-results">
        @foreach ($quizUser->attempts as $attempt)
            <div class="question-block" id="question-{{ $attempt->question->id }}">
                <h4 class="question-text">
                    {{ $attempt->question->question_content }}
                </h4>

                <ul class="choices-list">
                    @foreach ($attempt->question->choices as $choice)
                        @php
                            $isUserChoice = $attempt->choice && $attempt->choice->id === $choice->id;
                            $isCorrectChoice = $choice->is_correct;
                            $choiceClass = '';

                            if ($isCorrectChoice && $isUserChoice) {
                                $choiceClass = 'choice-correct-user'; // green outline, "your answer is correct"
                            } elseif ($isCorrectChoice) {
                                $choiceClass = 'choice-correct'; // green outline, "correct answer"
                            } elseif ($isUserChoice) {
                                $choiceClass = 'choice-wrong-user'; // red outline, "your answer"
                            } else {
                                $choiceClass = 'choice-default';
                            }
                        @endphp

                        <li class="choice-item {{ $choiceClass }}" data-choice-id="{{ $choice->id }}">
                            <div class="choice-content">
                                @if ($choice->choice_type === 'text')
                                    {{ $choice->choice_content }}
                                @else
                                    <img src="{{ asset('storage/' . $choice->choice_content) }}" alt="Choice Image">
                                @endif
                            </div>

                            <div class="choice-label">
                                @if ($isCorrectChoice && $isUserChoice)
                                    <span class="label label-success">✔ Your answer is correct</span>
                                @elseif ($isCorrectChoice)
                                    <span class="label label-success">✔ Correct answer</span>
                                @elseif ($isUserChoice)
                                    <span class="label label-error">✖ Your answer</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

</x-app-layout>
