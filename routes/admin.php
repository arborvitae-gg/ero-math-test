<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\ResultsController;
use App\Http\Controllers\Admin\QuestionController;

// Admin routes for user, quiz, question, and results management
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
            Route::get('/', [UserController::class, 'index'])->name('index');
            // Add more user management routes as needed
        });

    // Quizzes (resourceful, with custom post route)
    Route::resource('quizzes', QuizController::class)->except(['show']);
    // Show route (if needed)
    Route::get('quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    // Post quiz (custom action)
    Route::post('quizzes/{quiz}/post', [QuizController::class, 'post'])->name('quizzes.post');

    // Questions (resourceful, nested under quizzes)
    Route::resource('quizzes.questions', QuestionController::class);

    // Results (grouped under quizzes)
    Route::prefix('quizzes/{quiz}/results')->name('quizzes.results.')->group(function () {
        Route::get('/', [ResultsController::class, 'index'])->name('index');
        Route::get('/{quizUser}', [ResultsController::class, 'show'])->name('show');
        Route::post('/{quizUser}/toggle-visibility', [ResultsController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::post('/toggle-bulk-visibility', [ResultsController::class, 'toggleBulkVisibility'])
        ->name('toggle-bulk-visibility');
    });
});
