<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Quiz;
use App\Models\QuizUser;
use App\Services\Admin\ResultsService;

/**
 * Controller for managing quiz results in the admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class ResultsController
{
    protected $resultsService;

    public function __construct(ResultsService $resultsService)
    {
        $this->resultsService = $resultsService;
    }

    /**
     * Display a listing of quiz attempts for a quiz.
     *
     * @param Quiz $quiz
     * @return \Illuminate\View\View
     */
    public function index(Quiz $quiz)
    {
        $quizUsers = $quiz->quizUsers()->with(['user', 'category'])->get();
        return view('admin.quizzes.results.index', compact('quiz', 'quizUsers'));
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
        $quizUser->load(['attempts.question', 'attempts.choice', 'attempts.question.choices']);
        return view('admin.quizzes.results.show', compact('quiz', 'quizUser'));
    }

    /**
     * Toggle the visibility of a user's quiz score.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleVisibility(Quiz $quiz, QuizUser $quizUser)
    {
        try {
            $this->resultsService->toggleVisibility($quizUser);
            return back()->with('status', 'User score visibility updated.');
        } catch (\Throwable $e) {
            \Log::error('Toggle user score visibility failed', ['quiz_id' => $quiz->id, 'quiz_user_id' => $quizUser->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to update user score visibility. Please try again.');
        }
    }

    /**
     * Toggle the visibility of quiz scores for multiple users.
     *
     * @param Quiz $quiz
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleBulkVisibility(Quiz $quiz, Request $request)
    {
        $action = $request->input('action');
        $userIds = $request->input('users', []);
        try {
            $this->resultsService->toggleBulkVisibility($quiz, $action, $userIds);
            return back()->with('status', 'Bulk visibility updated successfully.');
        } catch (\Throwable $e) {
            \Log::error('Bulk toggle score visibility failed', ['quiz_id' => $quiz->id, 'action' => $action, 'user_ids' => $userIds, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to update bulk score visibility. Please try again.');
        }
    }
}
