<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="results-container">
        <div class="results-header">
            <h2>Quiz Results</h2>
            <p>Review your answers and see how well you did!</p>
        </div>

        <div class="results-summary">
            <div class="summary-card">
                <div class="summary-value">{{ $quizUser->total_score }}%</div>
                <div class="summary-label">Overall Score</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ $quizUser->attempts->where('is_correct', true)->count() }}</div>
                <div class="summary-label">Correct Answers</div>
            </div>
            <div class="summary-card">
                <div class="summary-value">{{ $quizUser->attempts->count() }}</div>
                <div class="summary-label">Total Questions</div>
            </div>
        </div>

        @foreach ($quizUser->attempts as $attempt)
            @php
                $question = $attempt->question;
            @endphp

            <div class="question-container">
                <div class="question-text">{{ $question->question_text }}</div>

                @if (!empty($question->question_image))
                    <img src="{{ $question->question_image_url }}" alt="Question Image" class="question-image">
                @endif

                <ul class="choices-list">
                    @php
                        $userAnswered = $attempt->choice !== null;
                    @endphp
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

                        <li class="choice-item {{ $choiceClass }}">
                            <div class="choice-content">
                                {{ $choice->choice_text }}
                                @if (!empty($choice->choice_image))
                                    <img src="{{ $choice->choice_image_url }}" alt="Choice Image" class="choice-image">
                                @endif
                            </div>

                            <div class="choice-label">
                                @if ($isCorrectChoice && $isUserChoice)
                                    <span class="label label-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Correct Answer
                                    </span>
                                @elseif ($isCorrectChoice)
                                    <span class="label label-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Correct Answer
                                    </span>
                                @elseif ($isUserChoice)
                                    <span class="label label-error">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Your Answer
                                    </span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                    @if (!$userAnswered)
                        <li class="choice-item choice-default">
                            <div class="choice-content" style="font-style:italic; color:#888;">
                                (You skipped this question)
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        @endforeach

        <div style="text-align: center;">
            <a href="{{ route('user.dashboard') }}" class="return-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    style="width: 20px; height: 20px;">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Return to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
