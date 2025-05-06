<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Category;
use App\Services\AdminQuizService;
use App\Http\Requests\Admin\AdminQuizRequest;

class AdminQuizController
{
    protected $service;

    public function __construct(AdminQuizService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $quizzes = Quiz::with('questions')->get();
        $categories = Category::all();

        return view('admin.quizzes.index', compact('quizzes', 'categories'));
    }

    public function store(AdminQuizRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz created!');
    }

    public function update(AdminQuizRequest $request, Quiz $quiz)
    {
        $this->service->update($quiz, $request->validated());

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz updated!');
    }

    public function destroy(Quiz $quiz)
    {
        $this->service->delete($quiz);

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz deleted!');
    }
}
