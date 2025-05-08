<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\Admin\AdminQuizResultsController;
use App\Http\Controllers\Admin\QuestionController;

Route::prefix('admin')
->middleware(['auth', 'verified', 'role:admin'])
->name('admin.')
->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // User
    Route::prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        // Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        // Route::patch('/{user}', [UserController::class, 'update'])->name('update');
    });

    // Quiz
    Route::resource('quizzes', AdminQuizController::class);

    // Quiz Questions
    Route::prefix('quizzes/{quiz}/questions')
    ->name('quizzes.questions.')
    ->group(function () {
        Route::get('/', [QuestionController::class, 'index'])
        ->name('index');

        Route::post('/', [QuestionController::class, 'store'])
        ->name('store');

        Route::patch('/{question}', [QuestionController::class, 'update'])
        ->name('update');

        Route::delete('/{question}', [QuestionController::class, 'destroy'])
        ->name('destroy');
    });

    // Quiz Results
    Route::prefix('quizzes/{quiz}/results')
    ->name('quizzes.results.')
    ->group(function () {
        Route::get('/', [AdminQuizResultsController::class, 'index'])
        ->name('index');

        Route::get('/{quizUser}', [AdminQuizResultsController::class, 'show'])
        ->name('show');

        Route::post('/{quizUser}/toggle-visibility', [AdminQuizResultsController::class, 'toggle-visibility'])
        ->name('toggle-visibility');
    });
});
