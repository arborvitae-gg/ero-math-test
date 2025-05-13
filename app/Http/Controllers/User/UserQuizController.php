<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\SaveAnswerRequest;
use App\Models\Quiz;
use App\Models\QuizUser;
use App\Models\Question;
use App\Services\User\QuizService;
use Illuminate\Support\Facades\Auth;

class UserQuizController
{
    protected QuizService $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index()
    {
        $user = Auth::user();

        // Fetch all posted quizzes with their questions
        $quizzes = Quiz::where('is_posted', true)->with('questions')->get();

        // Fetch all attempts by the current user, keyed by quiz_id
        $quizUsers = $user->quizSessions()->with('category')->get()->keyBy('quiz_id');

        return view('user.quizzes.index', compact('quizzes', 'user', 'quizUsers'));
    }

    public function start(Quiz $quiz)
    {
        $user = Auth::user();
        $quizUser = $this->quizService->startQuiz($quiz, $user);

        return redirect()->route('user.quizzes.attempts.show', [$quiz, $quizUser]);
    }

    public function show(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        [$question, $choices, $existingAttempt] = $this->quizService->getCurrentQuestionData($quizUser);

        return view('user.quizzes.take', compact('quizUser', 'quiz', 'question', 'choices', 'existingAttempt'));
    }

    public function saveAnswer(SaveAnswerRequest $request, Quiz $quiz, QuizUser $quizUser, Question $question)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        $this->quizService->processAnswerNavigation($quizUser, $question, $request);

        // Handle quiz submission
        if ($request->input('direction') === 'submit') {
            $this->quizService->submitQuiz($quizUser);
            return redirect()->route('user.quizzes.attempts.completed', [$quiz, $quizUser]);
        }

        return redirect()->route('user.quizzes.attempts.show', [$quiz, $quizUser]);
    }

    public function submit(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        $this->quizService->submitQuiz($quizUser);

        return redirect()->route('user.quizzes.attempts.completed', [$quiz, $quizUser]);
    }

    public function completed(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        return view('user.quizzes.completed', compact('quizUser', 'quiz'));
    }

    public function results(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        if (!$quizUser->can_view_score) {
            return view('user.quizzes.results-waiting', compact('quizUser', 'quiz'));
        }

        $attempts = $quizUser->attempts()->with(['question', 'choice'])->get();

        return view('user.quizzes.results', compact('quizUser', 'quiz', 'attempts'));
    }

    protected function authorizeQuizAccess(Quiz $quiz, QuizUser $quizUser): void
    {
        if ($quizUser->user_id !== Auth::id() || $quizUser->quiz_id !== $quiz->id) {
            abort(403);
        }
    }
}

