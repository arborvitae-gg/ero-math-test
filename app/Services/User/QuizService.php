<?php

namespace App\Services\User;

use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizUser;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\DB;

class QuizService
{
    /**
     * Start or resume a quiz attempt for a user.
     */
    public function startQuiz(Quiz $quiz, $user): QuizUser
    {
        // Identify category based on user's grade level
        $category = Category::findCategoryForGrade($user->grade_level);

        if (!$category) {
            abort(403, 'No quiz available for your grade level.');
        }

        // Prevent multiple attempts
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

        return $quizUser;
    }

    /**
     * Get randomized list of question IDs for the quiz + category.
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
     * Save or update a quiz answer.
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
                'choice_order' => $data['choice_order'] ?? [],
            ]
        );
    }

    /**
     * Final submission: calculate score and mark quiz as complete.
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
