<?php

namespace App\Services\Admin;

use App\Models\Quiz;
use App\Models\QuizUser;

class ResultsService
{
    /**
     * Toggle the visibility of a user's quiz score.
     *
     * @param QuizUser $quizUser
     * @return void
     */
    public function toggleVisibility(QuizUser $quizUser): void
    {
        $quizUser->can_view_score = !$quizUser->can_view_score;
        $quizUser->save();
    }

    /**
     * Toggle the visibility of quiz scores for multiple users.
     *
     * @param Quiz $quiz
     * @param string $action
     * @param array $userIds
     * @return void
     */
    public function toggleBulkVisibility(Quiz $quiz, string $action, array $userIds = []): void
    {
        if ($action === 'toggle_all') {
            $quizUsers = $quiz->quizUsers()->get();
        } else {
            $quizUsers = QuizUser::whereIn('id', $userIds)->get();
        }

        foreach ($quizUsers as $quizUser) {
            $quizUser->can_view_score = !$quizUser->can_view_score;
            $quizUser->save();
        }
    }
}
