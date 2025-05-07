<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\Admin\AdminQuizResultsController;
use App\Http\Controllers\Admin\QuestionController;

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserQuizController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')
->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');
});

Route::prefix('admin')
->middleware(['auth', 'role:admin'])
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

require __DIR__.'/auth.php';
