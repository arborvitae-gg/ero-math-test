<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

    // Question
    Route::resource('questions', QuestionController::class)->except(['show']);


});


// Placeholder, not yet final
// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
//     Route::get('/quiz/{id}/resume', [QuizController::class, 'resume'])->name('quiz.resume');
//     Route::post('/quiz/{quizId}/answer/{attemptId}', [QuizController::class, 'answer'])->name('quiz.answer');
//     Route::get('/quiz/{id}/complete', [QuizController::class, 'complete'])->name('quiz.complete');
// });

require __DIR__.'/auth.php';
