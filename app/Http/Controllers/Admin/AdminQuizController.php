<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminQuizController
{
    public function index()
    {
        $quizzes = Quiz::with('questions')->get();
        $categories = Category::all();

        return view('admin.quizzes', compact('quizzes', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'timer' => ['nullable', 'integer'],
            'is_posted' => ['nullable', 'boolean'],
        ]);

        $data['is_posted'] = $request->has('is_posted');

        Quiz::create($data);

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz created!');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'timer' => ['nullable', 'integer'],
            'is_posted' => ['nullable', 'boolean'],
        ]);

        $data['is_posted'] = $request->has('is_posted');

        $quiz->update($data);

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz updated!');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')->with('status', 'Quiz deleted!');
    }
}
