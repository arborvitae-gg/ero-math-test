<?php

namespace App\Services\User;

use Illuminate\Support\Facades\DB;

use App\Models\Quiz;
use App\Models\Category;
use App\Models\QuizUser;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\QuestionChoice;

/**
 * Service for user quiz logic (starting, answering, submitting quizzes).
 *
 * @package App\Services\User
 */
class QuizService
{
    /**
     * Generate a randomized order of questions for a quiz and category.
     *
     * @param Quiz $quiz
     * @param Category $category
     * @return array
     */
    protected function generateQuestionOrder(Quiz $quiz, Category $category): array
    {
        return Question::where('quiz_id', $quiz->id)
                       ->where('category_id', $category->id)
                       ->inRandomOrder()
                       ->pluck('id')
                       ->toArray();
    }

    /**
     * Get the current question, choices, and existing attempt for a quiz session.
     *
     * @param QuizUser $quizUser
     * @return array [Question, Collection<QuestionChoice>, QuizAttempt|null]
     */
    public function getCurrentQuestionData(QuizUser $quizUser)
    {
        $currentQuestionId = $quizUser->question_order[$quizUser->current_question - 1] ?? null;

        if (!$currentQuestionId) {
            abort(404, 'No more questions available.');
        }

        $question = Question::findOrFail($currentQuestionId);

        $choiceOrder = $quizUser->choice_orders[$question->id] ?? $question->choices->pluck('id')->toArray();

        $choices = QuestionChoice::whereIn('id', $choiceOrder)
            ->orderByRaw('array_position(ARRAY[' . implode(',', $choiceOrder) . '], id)')
            ->get();

        $existingAttempt = $quizUser->attempts->firstWhere('question_id', $question->id);

        return [$question, $choices, $existingAttempt];
    }

    /**
     * Start a new quiz session for a user.
     *
     * @param Quiz $quiz
     * @param $user
     * @return QuizUser
     */
    public function startQuiz(Quiz $quiz, $user): QuizUser
    {
        $category = Category::findCategoryForGrade($user->grade_level);

        if (!$category) {
            abort(403, 'No quiz available for your grade level.');
        }

        $quizUser = QuizUser::firstOrCreate([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
        ], [
            'category_id' => $category->id,
            'status' => 'in_progress',
            'current_question' => 1,
            'started_at' => now(),
            'question_order' => $this->generateQuestionOrder($quiz, $category),
        ]);

        // Save fixed choice order per question
        $choiceOrders = [];
        foreach ($quiz->questions as $question) {
            $choiceOrders[$question->id] = $question->choices->pluck('id')->shuffle()->toArray();
        }
        $quizUser->choice_orders = $choiceOrders;
        $quizUser->save();

        return $quizUser;
    }

    /**
     * Save a skipped answer for a question.
     *
     * @param QuizUser $quizUser
     * @param Question $question
     * @return void
     */
    protected function saveSkippedAnswer(QuizUser $quizUser, Question $question): void
    {
        QuizAttempt::create([
            'quiz_user_id' => $quizUser->id,
            'question_id' => $question->id,
            'question_choice_id' => null,
            'is_correct' => false,
            'answered_at' => now(),
        ]);
    }

    /**
     * Process answer submission and navigation for a quiz question.
     *
     * @param QuizUser $quizUser
     * @param Question $question
     * @param $request
     * @return void
     */
    public function processAnswerNavigation(QuizUser $quizUser, Question $question, $request): void
    {
        $validated = $request->validated();

        $existingAttempt = $quizUser->attempts()->where('question_id', $question->id)->first();

        // Handle answer changes or new answers
        if (isset($validated['choice_id'])) {
            if (!$existingAttempt || $existingAttempt->question_choice_id !== (int)$validated['choice_id']) {
                $this->saveAnswer($quizUser, $question, $validated);
            }
        }
        // Handle skipped questions (no answer selected)
        else {
            if (!$existingAttempt) {
                $this->saveSkippedAnswer($quizUser, $question);
            }
        }

        $this->updateNavigation($quizUser, $request->input('direction'));
    }

    /**
     * Update the current question navigation pointer.
     *
     * @param QuizUser $quizUser
     * @param $direction
     * @return void
     */
    protected function updateNavigation(QuizUser $quizUser, $direction): void
    {
        $total = count($quizUser->question_order);
        $current = $quizUser->current_question;

        if ($direction === 'next' && $current < $total) {
            $quizUser->current_question += 1;
        } elseif ($direction === 'previous' && $current > 1) {
            $quizUser->current_question -= 1;
        }

        $quizUser->save();
    }

    /**
     * Save or update a user's answer for a question.
     *
     * @param QuizUser $quizUser
     * @param Question $question
     * @param array $data
     * @return void
     */
    public function saveAnswer(QuizUser $quizUser, Question $question, array $data): void
    {
        QuizAttempt::updateOrCreate(
            [
                'quiz_user_id' => $quizUser->id,
                'question_id' => $question->id,
            ],
            [
                'question_choice_id' => $data['choice_id'],
                'is_correct' => QuestionChoice::findOrFail($data['choice_id'])->is_correct,
                'answered_at' => now(),
            ]
        );
    }

    /**
     * Submit the quiz for grading and update the user's score.
     *
     * @param QuizUser $quizUser
     * @return void
     */
    public function submitQuiz(QuizUser $quizUser): void
    {
        DB::transaction(function () use ($quizUser) {
            $score = QuizAttempt::where('quiz_user_id', $quizUser->id)
                                ->where('is_correct', true)
                                ->count();

            $quizUser->update([
                'status' => 'completed',
                'completed_at' => now(),
                'total_score' => $score,
            ]);
        });
    }

    /**
     * Get the quiz duration in seconds.
     *
     * @param Quiz $quiz
     * @return int|null
     */
    public function getQuizDuration(Quiz $quiz): ?int
    {
        return $quiz->timer !== null ? (int)$quiz->timer : null;
    }

    /**
     * Get the quiz end time for a user's attempt.
     *
     * @param QuizUser $quizUser
     * @return \Carbon\Carbon|null
     */
    public function getQuizEndTime(QuizUser $quizUser): ?\Carbon\Carbon
    {
        $duration = $this->getQuizDuration($quizUser->quiz);
        if ($duration === null) return null;
        return $quizUser->started_at->copy()->addSeconds($duration);
    }

    /**
     * Get the remaining time in seconds for a user's quiz attempt.
     *
     * @param QuizUser $quizUser
     * @return int|null
     */
    public function getRemainingTime(QuizUser $quizUser): ?int
    {
        $endTime = $this->getQuizEndTime($quizUser);
        if ($endTime === null) return null;
        $now = now();
        return max(0, $endTime->diffInSeconds($now, false) * -1);
    }

    /**
     * Check if the quiz time has expired for a user's attempt.
     *
     * @param QuizUser $quizUser
     * @return bool
     */
    public function isQuizExpired(QuizUser $quizUser): bool
    {
        $duration = $this->getQuizDuration($quizUser->quiz);
        if ($duration === null) return false;
        return $this->getRemainingTime($quizUser) <= 0;
    }

    /**
     * Handle quiz expiration and auto-submit if needed.
     * Returns true if the quiz was auto-submitted due to expiration.
     *
     * @param QuizUser $quizUser
     * @return bool
     */
    public function handleQuizExpiration(QuizUser $quizUser): bool
    {
        try {
            $quizDuration = $this->getQuizDuration($quizUser->quiz);
            if ($quizDuration !== null && $this->isQuizExpired($quizUser)) {
                $this->submitQuiz($quizUser);
                return true;
            }
            return false;
        }
        catch (\Throwable $e) {
            \Log::error('QuizService handleQuizExpiration failed', [
                'quiz_user_id' => $quizUser->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Prepare all data needed for the quiz attempt view.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return array
     */
    public function getQuizAttemptViewData(Quiz $quiz, QuizUser $quizUser): array
    {
        try {
            $quizDuration = $this->getQuizDuration($quiz);
            $remainingTime = $quizDuration !== null ? $this->getRemainingTime($quizUser) : null;
            [$question, $choices, $existingAttempt] = $this->getCurrentQuestionData($quizUser);
            $startedAt = $quizUser->started_at;
            return compact('quizUser', 'quiz', 'question', 'choices', 'existingAttempt', 'remainingTime', 'quizDuration', 'startedAt');
        }
        catch (\Throwable $e) {
            \Log::error('QuizService getQuizAttemptViewData failed', [
                'quiz_id' => $quiz->id,
                'quiz_user_id' => $quizUser->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Prepare all data needed for the quiz results view.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return array
     */
    public function getQuizResultsViewData(Quiz $quiz, QuizUser $quizUser): array
    {
        try {
            $attempts = $quizUser->attempts()->with(['question', 'choice'])->get();
            return compact('quizUser', 'quiz', 'attempts');
        }
        catch (\Throwable $e) {
            \Log::error('QuizService getQuizResultsViewData failed', [
                'quiz_id' => $quiz->id,
                'quiz_user_id' => $quizUser->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

}
