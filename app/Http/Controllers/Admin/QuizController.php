<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Category;
use App\Services\Admin\QuizService;
use App\Http\Requests\Admin\QuizRequest;

class QuizController
{
    protected $service;

    public function __construct(QuizService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $quizzes = Quiz::with('questions')->get();
        $categories = Category::all();

        return view('admin.quizzes.index', compact('quizzes', 'categories'));
    }

    public function store(QuizRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz created!');
    }

    public function update(QuizRequest $request, Quiz $quiz)
    {
        $this->service->update($quiz, $request->validated());

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz updated!');
    }

    public function destroy(Quiz $quiz)
    {
        $this->service->delete($quiz);

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz deleted!');
    }

    public function post(Quiz $quiz)
    {
        if ($quiz->is_posted) {
            return back()->with('status', 'Quiz is already posted.');
        }

        $quiz->update(['is_posted' => true]);

        return back()->with('status', 'Quiz has been posted. Editing and deleting are now disabled.');
    }
}
