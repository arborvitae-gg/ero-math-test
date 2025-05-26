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
        try {
            $quizUser->can_view_score = !$quizUser->can_view_score;
            $quizUser->save();
        } catch (\Throwable $e) {
            \Log::error('Toggle user score visibility failed', ['quiz_user_id' => $quizUser->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
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
        try {
            if ($action === 'toggle_all') {
                $quizUsers = $quiz->quizUsers()->get();
            } else {
                $quizUsers = QuizUser::whereIn('id', $userIds)->get();
            }
            foreach ($quizUsers as $quizUser) {
                $quizUser->can_view_score = !$quizUser->can_view_score;
                $quizUser->save();
            }
        } catch (\Throwable $e) {
            \Log::error('Bulk toggle score visibility failed', ['quiz_id' => $quiz->id, 'action' => $action, 'user_ids' => $userIds, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}
