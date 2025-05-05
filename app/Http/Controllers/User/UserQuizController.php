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

    /**
     * Display list of quizzes available to the user.
     */
    // public function index()
    // {
    //     $user = Auth::user();

    //     // Only show posted quizzes
    //     $quizzes = Quiz::where('is_posted', true)->with('questions')->get();

    //     return view('user.quizzes.index', compact('quizzes', 'user', 'quizUsers'));
    // }
    public function index()
    {
        $user = Auth::user();

        // Fetch all posted quizzes with their questions
        $quizzes = Quiz::where('is_posted', true)->with('questions')->get();

        // Fetch all attempts by the current user, keyed by quiz_id
        $quizUsers = $user->quizSessions()->with('category')->get()->keyBy('quiz_id');

        return view('user.quizzes.index', compact('quizzes', 'user', 'quizUsers'));
    }

    /**
     * Start a quiz — creates or resumes a QuizUser record.
     */
    public function start(Quiz $quiz)
    {
        $user = Auth::user();

        $quizUser = QuizUser::firstOrCreate(
            ['user_id' => $user->id, 'quiz_id' => $quiz->id],
            [
                'question_order' => $quiz->questions()->pluck('id')->shuffle()->toArray(),
                'current_question' => 1,
            ]
        );

        // Save choice orders per question
        $choiceOrders = [];
        foreach ($quiz->questions as $question) {
            $choiceOrders[$question->id] = $question->choices->pluck('id')->shuffle()->toArray();
        }

        $quizUser->choice_orders = $choiceOrders;
        $quizUser->save();

        return redirect()->route('user.quizzes.attempts.show', [$quiz, $quizUser]);
    }
    /**
     * Show current question during quiz.
     */
    public function show(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        $currentQuestionId = $quizUser->question_order[$quizUser->current_question - 1] ?? null;

        if (!$currentQuestionId) {
            return redirect()->route('user.dashboard')->with('error', 'No more questions available.');
        }

        $question = Question::with('choices')->findOrFail($currentQuestionId);
        $choices = $question->choices->shuffle(); // only visually; order saved on submit

        // dd([
        //     'quiz' => $quiz->slug,
        //     'quizUser' => $quizUser->uuid,
        //     'route' => route('user.quizzes.attempts.submit', [$quiz, $quizUser])
        // ]);

        return view('user.quizzes.take', compact('quizUser', 'quiz', 'question', 'choices'));
    }

    /**
     * Save or update a single answer and move to next/previous question.
     */
    public function saveAnswer(SaveAnswerRequest $request, Quiz $quiz, QuizUser $quizUser, Question $question)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        $validated = $request->validated();

        if (isset($validated['choice_order']) && is_string($validated['choice_order'])) {
            $validated['choice_order'] = json_decode($validated['choice_order'], true);
        }

        // Check if an answer was selected
        if (isset($validated['choice_id'])) {
            $existingAttempt = $quizUser->attempts()->where('question_id', $question->id)->first();

            if (!$existingAttempt || $existingAttempt->question_choice_id !== (int)$validated['choice_id']) {
                // Only save if no attempt yet or if the choice has changed
                $this->quizService->saveAnswer($quizUser, $question, $validated);
            }
        }

        // Always update navigation, even if no answer
        $direction = $request->input('direction');
        $total = count($quizUser->question_order);
        $current = $quizUser->current_question;

        if ($direction === 'next' && $current < $total) {
            $quizUser->current_question += 1;
        } elseif ($direction === 'previous' && $current > 1) {
            $quizUser->current_question -= 1;
        }

        $quizUser->save();
        $quizUser->refresh();

        return redirect()->route('user.quizzes.attempts.show', [$quiz, $quizUser]);
    }

    /**
     * Submit the quiz and mark as complete.
     */
    public function submit(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        $this->quizService->submitQuiz($quizUser);

        return redirect()->route('user.quizzes.attempts.completed', [$quiz, $quizUser]);
    }

    /**
     * Show congratulations and certificate download button.
     */
    public function completed(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        return view('user.quizzes.completed', compact('quizUser', 'quiz'));
    }

    /**
     * Show results — if user has permission.
     */
    public function results(Quiz $quiz, QuizUser $quizUser)
    {
        $this->authorizeQuizAccess($quiz, $quizUser);

        if (!$quizUser->can_view_score) {
            return view('user.quizzes.results-waiting', compact('quizUser', 'quiz'));
        }

        $attempts = $quizUser->attempts()->with(['question', 'selectedChoice'])->get();

        return view('user.quizzes.results', compact('quizUser', 'quiz', 'attempts'));
    }

    /**
     * Prevent user from accessing someone else's quiz.
     */
    protected function authorizeQuizAccess(Quiz $quiz, QuizUser $quizUser): void
    {
        if ($quizUser->user_id !== Auth::id() || $quizUser->quiz_id !== $quiz->id) {
            abort(403);
        }
    }
}

