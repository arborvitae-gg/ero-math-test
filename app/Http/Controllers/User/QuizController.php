<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;

use App\Models\Quiz;
use App\Models\QuizUser;
use App\Models\Question;
use App\Services\User\QuizService;
use App\Http\Requests\User\SaveAnswerRequest;

/**
 * Controller for handling user quiz interactions.
 *
 * @package App\Http\Controllers\User
 */
class QuizController
{
    /**
     * The quiz service instance.
     *
     * @var QuizService
     */
    protected QuizService $quizService;

    /**
     * Inject QuizService dependency.
     *
     * @param QuizService $quizService
     */
    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    /**
     * Display the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $quizzes = Quiz::where('is_posted', true)->with('questions')->get();
        $quizUsers = $user->quizSessions()->with('category')->get()->keyBy('quiz_id');

        return view('user.dashboard', compact('quizzes', 'user', 'quizUsers'));
    }

    /**
     * Display a list of available quizzes and user attempts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $quizzes = Quiz::where('is_posted', true)->with('questions')->get();
        $quizUsers = $user->quizSessions()->with('category')->get()->keyBy('quiz_id');

        return view('user.quizzes.index', compact('quizzes', 'user', 'quizUsers'));
    }

    /**
     * Start a new quiz attempt for the user.
     *
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start(Quiz $quiz)
    {
        $user = Auth::user();
        $quizUser = $this->quizService->startQuiz($quiz, $user);

        return redirect()->route('user.quizzes.attempts.show', [$quiz, $quizUser]);
    }

    /**
     * Show the current quiz question for the user.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return \Illuminate\View\View
     */
    public function show(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        [$question, $choices, $existingAttempt] = $this->quizService->getCurrentQuestionData($quizUser);

        return view('user.quizzes.take', compact('quizUser', 'quiz', 'question', 'choices', 'existingAttempt'));
    }

    /**
     * Save the user's answer and handle navigation or submission.
     *
     * @param SaveAnswerRequest $request
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Submit the quiz attempt for grading.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        $this->quizService->submitQuiz($quizUser);

        return redirect()->route('user.quizzes.attempts.completed', [$quiz, $quizUser]);
    }

    /**
     * Show the completed quiz summary to the user.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return \Illuminate\View\View
     */
    public function completed(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        return view('user.quizzes.completed', compact('quizUser', 'quiz'));
    }

    /**
     * Show the quiz results to the user.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return \Illuminate\View\View
     */
    public function results(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        // if (!$quizUser->can_view_score) {
        //     return view('user.quizzes.results-waiting', compact('quizUser', 'quiz'));
        // }

        $attempts = $quizUser->attempts()->with(['question', 'choice'])->get();

        return view('user.quizzes.results', compact('quizUser', 'quiz', 'attempts'));
    }

    /**
     * Ensure the authenticated user can access the quiz attempt.
     *
     * @param Quiz $quiz
     * @param QuizUser $quizUser
     * @return void
     */
    protected function authorizeQuizAccess(Quiz $quiz, QuizUser $quizUser): void
    {
        if ($quizUser->user_id !== Auth::id() || $quizUser->quiz_id !== $quiz->id) {
            abort(403);
        }
    }
}

