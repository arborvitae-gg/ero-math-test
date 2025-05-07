<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserQuizController;

Route::middleware(['auth', 'role:user'])
->prefix('user')
->name('user.')
->group(function () {
    // User Dashboard
    Route::get('/dashboard', [UserQuizController::class, 'index'])
    ->name('dashboard');

    Route::post('/quizzes/{quiz}/start', [UserQuizController::class, 'start'])
    ->name('quizzes.start');

    // Quiz Attempts
    Route::prefix('quizzes/{quiz}/attempts')->name('quizzes.attempts.')->group(function () {
        Route::get('/{quizUser}', [UserQuizController::class, 'show'])
        ->name('show');

        Route::post('/{quizUser}/questions/{question}/save', [UserQuizController::class, 'saveAnswer'])
        ->name('saveAnswer');

        Route::post('/{quizUser}/submit', [UserQuizController::class, 'submit'])
        ->name('submit');

        Route::get('/{quizUser}/completed', [UserQuizController::class, 'completed'])
        ->name('completed');

        Route::get('/{quizUser}/results', [UserQuizController::class, 'results'])
        ->name('results');
    });
});
