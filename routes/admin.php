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
        Route::get('/', [AdminQuizController::class, 'index'])
        ->name('index');

        Route::post('/', [AdminQuizController::class, 'store'])
        ->name('store');

        Route::get('/create', [AdminQuizController::class, 'create'])
        ->name('create');

        Route::get('/{quiz}', [AdminQuizController::class, 'show'])
        ->name('show');

        Route::get('/{quiz}/edit', [AdminQuizController::class, 'edit'])
        ->name('edit');

        Route::patch('/{quiz}', [AdminQuizController::class, 'update'])
        ->name('update');

        Route::delete('/{quiz}', [AdminQuizController::class, 'destroy'])
        ->name('destroy');

        Route::post('/{quiz}/post', [AdminQuizController::class, 'post'])
        ->name('post');

        // Quiz Questions
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

        // Quiz Results
        Route::prefix('{quiz}/results')->name('results.')->group(function () {
            Route::get('/', [AdminQuizResultsController::class, 'index'])
            ->name('index');

            Route::get('/{quizUser}', [AdminQuizResultsController::class, 'show'])
            ->name('show');

            Route::post('/{quizUser}/toggle-visibility', [AdminQuizResultsController::class, 'toggleVisibility'])
            ->name('toggle-visibility');
        });
    });
});
