<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\ResultsController;
use App\Http\Controllers\Admin\QuestionController;

Route::prefix('admin')
->middleware(['auth', 'verified', 'role:admin'])
->name('admin.')
->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Users
    Route::prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])
        ->name('index');

        // Route::get('/{user}/edit', [UserController::class, 'edit'])
        // ->name('edit');

        // Route::patch('/{user}', [UserController::class, 'update'])
        // ->name('update');
    });

    Route::prefix('quizzes')
        ->name('quizzes.')
        ->group(function () {
        // CRUD Quiz
        Route::get('/', [QuizController::class, 'index'])
        ->name('index');

        Route::post('/', [QuizController::class, 'store'])
        ->name('store');

        Route::get('/create', [QuizController::class, 'create'])
        ->name('create');

        Route::get('/{quiz}', [QuizController::class, 'show'])
        ->name('show');

        Route::get('/{quiz}/edit', [QuizController::class, 'edit'])
        ->name('edit');

        Route::patch('/{quiz}', [QuizController::class, 'update'])
        ->name('update');

        Route::delete('/{quiz}', [QuizController::class, 'destroy'])
        ->name('destroy');

        Route::post('/{quiz}/post', [QuizController::class, 'post'])
        ->name('post');

        // Questions
        Route::prefix('{quiz}/questions')->name('questions.')->group(function () {
            Route::get('/', [QuestionController::class, 'index'])
            ->name('index');

            Route::post('/', [QuestionController::class, 'store'])
            ->name('store');

            Route::patch('/{question}', [QuestionController::class, 'update'])
            ->name('update');

            Route::delete('/{question}', [QuestionController::class, 'destroy'])
            ->name('destroy');
        });

        // Results
        Route::prefix('{quiz}/results')->name('results.')->group(function () {
            Route::get('/', [ResultsController::class, 'index'])
            ->name('index');

            Route::get('/{quizUser}', [ResultsController::class, 'show'])
            ->name('show');

            Route::post('/{quizUser}/toggle-visibility', [ResultsController::class, 'toggleVisibility'])
            ->name('toggle-visibility');
        });
    });
});
