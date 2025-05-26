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
     * Display a list of available quizzes and user attempts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $quizzes = Quiz::where('is_posted', true)->with('questions')->get();
            $quizUsers = $user->quizSessions()->with('category')->get()->keyBy('quiz_id');
            return view('user.quizzes.index', compact('quizzes', 'user', 'quizUsers'));
        } catch (\Throwable $e) {
            \Log::error('User quiz dashboard failed', ['user_id' => Auth::id(), 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to load quizzes. Please try again.');
        }
    }

    /**
     * Start a new quiz attempt for the user.
     *
     * @param Quiz $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start(Quiz $quiz)
    {
        try {
            $user = Auth::user();
            $quizUser = $this->quizService->startQuiz($quiz, $user);
            return redirect()->route('user.quizzes.attempts.show', [$quiz, $quizUser]);
        } catch (\Throwable $e) {
            \Log::error('User start quiz failed', ['user_id' => Auth::id(), 'quiz_id' => $quiz->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to start quiz. Please try again.');
        }
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
        try {
            $this->authorizeQuizAccess($quiz, $quizUser);
            [$question, $choices, $existingAttempt] = $this->quizService->getCurrentQuestionData($quizUser);
            return view('user.quizzes.take', compact('quizUser', 'quiz', 'question', 'choices', 'existingAttempt'));
        } catch (\Throwable $e) {
            \Log::error('User show quiz question failed', ['user_id' => Auth::id(), 'quiz_id' => $quiz->id, 'quiz_user_id' => $quizUser->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to load quiz question. Please try again.');
        }
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
        try {
            $this->authorizeQuizAccess($quiz, $quizUser);
            $this->quizService->processAnswerNavigation($quizUser, $question, $request);
            if ($request->input('direction') === 'submit') {
                $this->quizService->submitQuiz($quizUser);
                return redirect()->route('user.quizzes.attempts.completed', [$quiz, $quizUser]);
            }
            return redirect()->route('user.quizzes.attempts.show', [$quiz, $quizUser]);
        } catch (\Throwable $e) {
            \Log::error('User save answer failed', ['user_id' => Auth::id(), 'quiz_id' => $quiz->id, 'quiz_user_id' => $quizUser->id, 'question_id' => $question->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to save answer. Please try again.');
        }
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
        try {
            $this->authorizeQuizAccess($quiz, $quizUser);
            $this->quizService->submitQuiz($quizUser);
            return redirect()->route('user.quizzes.attempts.completed', [$quiz, $quizUser]);
        } catch (\Throwable $e) {
            \Log::error('User submit quiz failed', ['user_id' => Auth::id(), 'quiz_id' => $quiz->id, 'quiz_user_id' => $quizUser->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to submit quiz. Please try again.');
        }
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
        try {
            $this->authorizeQuizAccess($quiz, $quizUser);
            return view('user.quizzes.completed', compact('quizUser', 'quiz'));
        } catch (\Throwable $e) {
            \Log::error('User completed quiz view failed', ['user_id' => Auth::id(), 'quiz_id' => $quiz->id, 'quiz_user_id' => $quizUser->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to load completed quiz. Please try again.');
        }
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
        try {
            $this->authorizeQuizAccess($quiz, $quizUser);
            $attempts = $quizUser->attempts()->with(['question', 'choice'])->get();
            return view('user.quizzes.results', compact('quizUser', 'quiz', 'attempts'));
        } catch (\Throwable $e) {
            \Log::error('User quiz results failed', ['user_id' => Auth::id(), 'quiz_id' => $quiz->id, 'quiz_user_id' => $quizUser->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to load quiz results. Please try again.');
        }
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

