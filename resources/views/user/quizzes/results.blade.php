<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quiz Results') }}</h2>
    </x-slot>

    <div id="quiz-results">
        @foreach ($quizUser->attempts as $attempt)
            @php
                $question = $attempt->question;
            @endphp

            <div class="question-block" id="question-{{ $question->id }}">
                <h3>{{ $question->question_text }}</h3>

                @if (!empty($question->question_image))
                    <img src="{{ $question->question_image_url }}" alt="Question Image">
                @endif

                <ul class="choices-list">
                    @foreach ($question->choices as $choice)
                        @php
                            $isUserChoice = $attempt->choice && $attempt->choice->id === $choice->id;
                            $isCorrectChoice = $choice->is_correct;

                            if ($isCorrectChoice && $isUserChoice) {
                                $choiceClass = 'choice-correct-user';
                            } elseif ($isCorrectChoice) {
                                $choiceClass = 'choice-correct';
                            } elseif ($isUserChoice) {
                                $choiceClass = 'choice-wrong-user';
                            } else {
                                $choiceClass = 'choice-default';
                            }
                        @endphp

                        <li class="choice-item {{ $choiceClass }}" data-choice-id="{{ $choice->id }}">
                            <div class="choice-content">
                                {{ $choice->choice_text }}
                                @if (!empty($choice->choice_image))
                                    <img src="{{ $choice->choice_image_url }}" alt="Choice Image">
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

    <div>
        <a href="{{ route('user.dashboard') }}">Return to Dashboard</a>
    </div>
</x-app-layout>
