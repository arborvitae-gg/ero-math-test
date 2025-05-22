<?php

namespace App\Services\Admin;

use App\Models\Quiz;

/**
 * Service for admin quiz management logic.
 *
 * @package App\Services\Admin
 */
class QuizService
{
    /**
     * Store a new quiz.
     *
     * @param array $data
     * @return Quiz
     */
    public function store(array $data): Quiz
    {
        return Quiz::create($data);
    }

    /**
     * Update an existing quiz.
     *
     * @param Quiz $quiz
     * @param array $data
     * @return Quiz
     */
    public function update(Quiz $quiz, array $data): Quiz
    {
        $quiz->update($data);
        return $quiz;
    }

    /**
     * Delete a quiz.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function delete(Quiz $quiz): void
    {
        $quiz->delete();
    }
}
