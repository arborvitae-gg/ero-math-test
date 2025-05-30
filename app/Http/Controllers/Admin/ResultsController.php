<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Quiz;
use App\Models\QuizUser;

/**
 * Controller for managing quiz results in the admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class ResultsController
{

    /**
     * Display a listing of quiz attempts for a quiz.
     *
     * @param Quiz $quiz
     * @return \Illuminate\View\View
     */
    public function index(Quiz $quiz)
    {
        try {
            $quizUsers = $quiz->quizUsers()->with(['user', 'category'])->get();
            return view('admin.quizzes.results.index', compact('quiz', 'quizUsers'));
        }
        catch (\Throwable $e) {
            \Log::error('Admin results index failed', [
                'quiz_id' => $quiz->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors('Failed to load quiz results. Please try again.');
        }
    }

    /**
     * Display the details of a user's quiz attempt.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return \Illuminate\View\View
     */
    public function show(Quiz $quiz, QuizUser $quizUser)
    {
        try {
            $quizUser->load(['attempts.question', 'attempts.choice', 'attempts.question.choices']);
            return view('admin.quizzes.results.show', compact('quiz', 'quizUser'));
        }
        catch (\Throwable $e) {
            \Log::error('Admin results show failed', [
                'quiz_id' => $quiz->id,
                'quiz_user_id' => $quizUser->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors('Failed to load quiz attempt details. Please try again.');
        }
    }
}
