<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\StartQuizRequest;
use App\Http\Requests\User\SaveAnswerRequest;
use App\Models\Quiz;
use App\Models\QuizUser;
use App\Models\Question;
use App\Services\User\QuizService;
use Illuminate\Support\Facades\Auth;

class UserQuizController
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index()
    {
        $user = Auth::user();
        $quizzes = Quiz::where('is_posted', true)->with('questions')->get();

        return view('user.quizzes.index', compact('quizzes', 'user'));
    }

    public function start(StartQuizRequest $request, Quiz $quiz)
    {
        $user = Auth::user();
        $quizUser = $this->quizService->startQuiz($quiz, $user);

        return redirect()->route('user.quizzes.show', ['quizUser' => $quizUser->uuid]);
    }

    public function show(QuizUser $quizUser)
    {
        $this->authorizeAccess($quizUser);

        $currentQuestionId = $quizUser->question_order[$quizUser->current_question - 1] ?? null;

        if (!$currentQuestionId) {
            return redirect()->route('user.dashboard')->with('error', 'No more questions available.');
        }

        $question = Question::with('choices')->findOrFail($currentQuestionId);
        $choices = $question->choices->shuffle(); // This shuffling will only be shown first time

        return view('user.quizzes.take', compact('quizUser', 'question', 'choices'));
    }

    public function saveAnswer(SaveAnswerRequest $request, QuizUser $quizUser, Question $question)
    {
        $this->authorizeAccess($quizUser);

        $this->quizService->saveAnswer($quizUser, $question, $request->validated());

        return response()->json(['success' => true]);
    }

    public function submit(QuizUser $quizUser)
    {
        $this->authorizeAccess($quizUser);

        $this->quizService->submitQuiz($quizUser);

        return redirect()->route('user.quizzes.completed');
    }

    public function completed()
    {
        return view('user.quizzes.completed');
    }

    public function results(QuizUser $quizUser)
    {
        $this->authorizeAccess($quizUser);

        $attempts = $quizUser->attempts()->with(['question', 'selectedChoice'])->get();

        return view('user.quizzes.results', compact('quizUser', 'attempts'));
    }

    protected function authorizeAccess(QuizUser $quizUser)
    {
        if ($quizUser->user_id !== Auth::id()) {
            abort(403);
        }
    }
}

