<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Category;
use App\Services\Admin\QuizService;
use App\Http\Requests\Admin\QuizRequest;

/**
 * Controller for managing quizzes in the admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class QuizController
{
    /**
     * The quiz service instance.
     *
     * @var QuizService
     */
    protected $service;

    /**
     * Inject QuizService dependency.
     *
     * @param QuizService $service
     */
    public function __construct(QuizService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of quizzes and categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $quizzes = Quiz::with('questions')->get();
        $categories = Category::all();

        return view('admin.quizzes.index', compact('quizzes', 'categories'));
    }

    /**
     * Store a newly created quiz in storage.
     *
     * @param QuizRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuizRequest $request)
    {
        try {
            $this->service->store($request->validated());
            return redirect()->route('admin.quizzes.index')->with('status', 'Quiz created!');
        } catch (\Throwable $e) {
            \Log::error('Quiz creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to create quiz. Please try again.');
        }
    }

    /**
     * Update the specified quiz in storage.
     *
     * @param QuizRequest $request
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuizRequest $request, Quiz $quiz)
    {
        try {
            $this->service->update($quiz, $request->validated());
            return redirect()->route('admin.quizzes.index')->with('status', 'Quiz updated!');
        } catch (\Throwable $e) {
            \Log::error('Quiz update failed', ['quiz_id' => $quiz->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to update quiz. Please try again.');
        }
    }

    /**
     * Remove the specified quiz from storage.
     *
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Quiz $quiz)
    {
        try {
            $this->service->delete($quiz);
            return redirect()->route('admin.quizzes.index')->with('status', 'Quiz deleted!');
        } catch (\Throwable $e) {
            \Log::error('Quiz deletion failed', ['quiz_id' => $quiz->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to delete quiz. Please try again.');
        }
    }

    /**
     * Post the quiz, making it available to users.
     *
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(Quiz $quiz)
    {
        try {
            if ($quiz->is_posted) {
                return back()->with('status', 'Quiz is already posted.');
            }
            $quiz->update(['is_posted' => true]);
            return back()->with('status', 'Quiz has been posted. Editing and deleting are now disabled.');
        } catch (\Throwable $e) {
            \Log::error('Quiz post failed', ['quiz_id' => $quiz->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to post quiz. Please try again.');
        }
    }
}
