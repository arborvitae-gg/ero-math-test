<?php


use App\Http\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\Admin\AdminQuizResultsController;
use App\Http\Controllers\Admin\QuestionController;

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserQuizController;

// Main web routes
Route::get('/', function () {
    return view('welcome');
});

// Dashboard routes, redirecting based on user role
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile management routes (shared by all authenticated users)
Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

// Load additional route files
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/user.php';
