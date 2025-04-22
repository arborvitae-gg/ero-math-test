<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;
use App\Models\QuestionChoice;
use App\Http\Requests\StoreQuestionRequest;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    protected $service;

    public function __construct(QuestionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $questions = Question::with('choices')->get();
        $categories = Category::all();

        return view('admin.questions', compact('questions', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.create-question', compact('categories'));
    }

    public function store(StoreQuestionRequest $request)
    {
        $this->service->store($request->validated());
        return redirect()->route('admin.questions.index')->with('status', 'Question created!');
    }

    public function edit(Question $question)
    {
        $question->load('choices');
        $categories = Category::all();
        return view('admin.edit-question', compact('question', 'categories'));
    }

    public function update(StoreQuestionRequest $request, Question $question)
    {
        $this->service->update($question, $request->validated());
        return redirect()->route('admin.questions.index')->with('status', 'Question updated!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('status', 'Question deleted!');
    }
}

