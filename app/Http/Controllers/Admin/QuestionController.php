<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Category;
use App\Models\QuestionChoice;
use App\Services\QuestionService;
use App\Http\Requests\Admin\StoreQuestionRequest;

class QuestionController
{
    protected $service;

    public function __construct(QuestionService $service)
    {
        $this->service = $service;
    }

    // GET /admin/quizzes/{quiz}/questions
    public function index(Quiz $quiz)
    {
        $categories = Category::all();
        $questions = $quiz->questions()->with('choices')->get();

        return view('admin.questions', compact('quiz', 'questions', 'categories'));
    }

    // POST /admin/quizzes/{quiz}/questions
    public function store(StoreQuestionRequest $request, Quiz $quiz)
    {
        $data = $request->validated();
        $data['quiz_id'] = $quiz->id; // inject quiz into payload

        $this->service->store($data);

        return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question created!');
    }

    // PATCH /admin/quizzes/{quiz}/questions/{question}
    public function update(StoreQuestionRequest $request, Quiz $quiz, Question $question)
    {
        $this->service->update($question, $request->validated());

        return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question updated!');
    }

    // DELETE /admin/quizzes/{quiz}/questions/{question}
    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.quizzes.questions.index', $quiz)->with('status', 'Question deleted!');
    }
}

