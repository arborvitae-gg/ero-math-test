<?php

namespace App\Services\User;

use App\Models\Quiz;
use App\Models\Category;
use App\Models\QuizUser;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\QuestionChoice;

class QuizService
{
    public function startQuiz(Quiz $quiz, $user)
    {
        $category = Category::findCategoryForGrade($user->grade_level);

        if (!$category) {
            abort(403, 'No quiz available for your grade level.');
        }

        $quizUser = QuizUser::firstOrCreate([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
        ],
        [
            'category_id' => $category->id,
            'status' => 'in_progress',
            'current_question' => 1,
            'started_at' => now(),
            'question_order' => $this->generateRandomQuestionOrder($quiz, $user),
        ]);

        return $quizUser;
    }

    protected function generateRandomQuestionOrder(Quiz $quiz, $category)
    {
        return $quiz->questions()
            ->where('category_id', $category->id)
            ->inRandomOrder()
            ->pluck('id')
            ->toArray();
    }

    public function saveAnswer(QuizUser $quizUser, Question $question, array $data)
    {
        return QuizAttempt::updateOrCreate(
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

    public function submitQuiz(QuizUser $quizUser)
    {
        $quizUser->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
