<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Category;
use App\Models\QuestionChoice;
use App\Services\QuestionService;
use App\Http\Requests\Admin\QuestionRequest;

class QuestionController
{
    protected $service;

    public function __construct(QuestionService $service)
    {
        $this->service = $service;
    }

    public function index(Quiz $quiz)
    {
        $categories = Category::all();
        $questions = $quiz->questions()->with('choices')->get();

        return view('admin.questions', compact('quiz', 'questions', 'categories'));
    }

    public function store(QuestionRequest $request, Quiz $quiz)
    {
        $this->service->store($request->validated());

        return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question created!');
    }

    public function update(QuestionRequest $request, Quiz $quiz, Question $question)
    {
        $this->service->update($question, $request->validated());

        return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question updated!');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $this->service->delete($question);

        return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question deleted!');
    }
}

