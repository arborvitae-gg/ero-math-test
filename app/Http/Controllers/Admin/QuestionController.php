<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Category;
use App\Models\QuestionChoice;
use App\Services\Admin\QuestionService;
use App\Http\Requests\Admin\QuestionRequest;

/**
 * Controller for managing quiz questions in the admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class QuestionController
{
    /**
     * The question service instance.
     *
     * @var QuestionService
     */
    protected $service;

    /**
     * Inject QuestionService dependency.
     *
     * @param QuestionService $service
     */
    public function __construct(QuestionService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of questions for a quiz.
     *
     * @param Quiz $quiz
     * @return \Illuminate\View\View
     */
    public function index(Quiz $quiz)
    {
        try {
            $categories = Category::all();
            $questions = $quiz->questions()->with('choices')->get();

            return view('admin.quizzes.questions', compact('quiz', 'questions', 'categories'));
        }
        catch (\Throwable $e) {
            \Log::error('Admin questions index failed', [
                'quiz_id' => $quiz->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors('Failed to load questions. Please try again.');
        }
    }

    /**
     * Store a newly created question in storage.
     *
     * @param QuestionRequest $request
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionRequest $request, Quiz $quiz)
    {
        try {
            $this->service->store($request->validated());
            return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question created!');
        }
        catch (\Throwable $e) {
            \Log::error('Question creation failed', [
                    'quiz_id' => $quiz->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            return back()->withErrors('Failed to create question. Please try again.');
        }
    }

    /**
     * Update the specified question in storage.
     *
     * @param QuestionRequest $request
     * @param Quiz $quiz
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionRequest $request, Quiz $quiz, Question $question)
    {
        try {
            $this->service->update($question, $request->validated());
            return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question updated!');
        }
        catch (\Throwable $e) {
            \Log::error('Question update failed', [
                    'quiz_id' => $quiz->id,
                    'question_id' => $question->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            return back()->withErrors('Failed to update question. Please try again.');
        }
    }

    /**
     * Remove the specified question from storage.
     *
     * @param Quiz $quiz
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        try {
            $this->service->delete($question);
            return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question deleted!');
        }
        catch (\Throwable $e) {
            \Log::error('Question deletion failed', [
                    'quiz_id' => $quiz->id,
                    'question_id' => $question->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors('Failed to delete question. Please try again.');
        }
    }
}
