<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function start()
    {
        $user = auth()->user();

        // Check for existing quiz in progress
        $quiz = Quiz::where('user_id', $user->id)
                    ->where('status', 'in_progress')
                    ->first();

        if ($quiz) {
            return redirect()->route('quiz.resume', $quiz->id);
        }

        // Get user's category based on grade level
        $category = Category::where('min_grade', '<=', $user->grade_level)
                            ->where('max_grade', '>=', $user->grade_level)
                            ->firstOrFail();

        // Create a new quiz
        $quiz = Quiz::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // Get 10 random questions from category
        $questions = Question::where('category_id', $category->id)
                            ->inRandomOrder()
                            ->take(10)
                            ->get();

        // Store quiz_attempts with null choices initially
        foreach ($questions as $question) {
            QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'question_id' => $question->id,
                'question_choice_id' => null,
                'is_correct' => false,
            ]);
        }

        return redirect()->route('quiz.resume', $quiz->id);
    }

    public function resume($id)
    {
        $quiz = Quiz::with(['attempts.question.choices'])
                    ->where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('status', 'in_progress')
                    ->firstOrFail();

        // Find next unanswered attempt
        $nextAttempt = $quiz->attempts()->whereNull('question_choice_id')->first();

        if (!$nextAttempt) {
            return redirect()->route('quiz.complete', $quiz->id);
        }

        return view('quiz.question', compact('quiz', 'nextAttempt'));
    }

    public function answer(Request $request, $quizId, $attemptId)
    {
        $request->validate([
            'choice_id' => 'required|exists:question_choices,id',
        ]);

        $attempt = QuizAttempt::where('id', $attemptId)
                            ->where('quiz_id', $quizId)
                            ->firstOrFail();

        $choice = QuestionChoice::findOrFail($request->choice_id);

        $attempt->update([
            'question_choice_id' => $choice->id,
            'is_correct' => $choice->is_correct,
        ]);

        return redirect()->route('quiz.resume', $quizId);
    }

    public function complete($id)
    {
        $quiz = Quiz::with('attempts.choice')
                    ->where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        $score = $quiz->attempts->where('is_correct', true)->count();

        $quiz->update([
            'status' => 'completed',
            'completed_at' => now(),
            'total_score' => $score,
        ]);

        return view('quiz.result', compact('quiz', 'score'));
    }




}
