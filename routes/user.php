<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\QuizController;
use App\Http\Controllers\User\ProfileController;

Route::middleware(['auth', 'verified','role:user'])
->prefix('user')
->name('user.')
->group(function () {
    // User Dashboard
    Route::get('/dashboard', [QuizController::class, 'index'])
    ->name('dashboard');

    Route::post('/quizzes/{quiz}/start', [QuizController::class, 'start'])
    ->name('quizzes.start');

    // Quiz Attempts
    Route::prefix('quizzes/{quiz}/attempts')->name('quizzes.attempts.')->group(function () {
        Route::get('/{quizUser}', [QuizController::class, 'show'])
        ->name('show');

        Route::post('/{quizUser}/questions/{question}/save', [QuizController::class, 'saveAnswer'])
        ->name('saveAnswer');

        Route::post('/{quizUser}/submit', [QuizController::class, 'submit'])
        ->name('submit');

        Route::get('/{quizUser}/completed', [QuizController::class, 'completed'])
        ->name('completed');

        Route::get('/{quizUser}/results', [QuizController::class, 'results'])
        ->name('results');
    });
});
