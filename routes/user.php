<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\QuizController;

// User routes for quiz participation and profile management
Route::middleware(['auth', 'role:user']) // verified
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // User Dashboard
        Route::get('/dashboard', [QuizController::class, 'index'])->name('dashboard');

        // Start a quiz
        Route::post('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');

        // Quiz Attempts (grouped for clarity)
        Route::prefix('quizzes/{quiz}/attempts')->name('quizzes.attempts.')->group(function () {
            Route::get('/{quizUser}', [QuizController::class, 'show'])->name('show');
            Route::post('/{quizUser}/questions/{question}/save', [QuizController::class, 'saveAnswer'])->name('saveAnswer');
            Route::post('/{quizUser}/submit', [QuizController::class, 'submit'])->name('submit');
            Route::get('/{quizUser}/completed', [QuizController::class, 'completed'])->name('completed');
            Route::get('/{quizUser}/results', [QuizController::class, 'results'])->name('results');
        });
    });
