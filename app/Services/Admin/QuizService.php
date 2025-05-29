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
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
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
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
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
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
        $quiz->delete();
    }
}
