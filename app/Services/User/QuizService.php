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

}
