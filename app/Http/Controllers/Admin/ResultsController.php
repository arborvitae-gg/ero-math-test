<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\QuizUser;

class ResultsController
{
    public function index(Quiz $quiz)
    {
        $quizUsers = $quiz->quizUsers()->with(['user', 'category'])->get();
        return view('admin.quizzes.results.index', compact('quiz', 'quizUsers'));
    }

    public function show(Quiz $quiz, QuizUser $quizUser)
    {
        $quizUser->load(['attempts.question', 'attempts.choice', 'attempts.question.choices']);
        return view('admin.quizzes.results.show', compact('quiz', 'quizUser'));
    }

    public function toggleVisibility(Quiz $quiz, QuizUser $quizUser)
    {
        $quizUser->can_view_score = !$quizUser->can_view_score;
        $quizUser->save();

        return back()->with('status', 'User score visibility updated.');
    }
}

