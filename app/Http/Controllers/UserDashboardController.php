<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['userResult' => function ($query) {
                $query->where('user_id', Auth::id());
            }, 'userProgress' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->withCount('questions')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('quizzes'));
    }
} 