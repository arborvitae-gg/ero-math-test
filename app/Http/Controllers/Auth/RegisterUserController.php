<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * Controller for user registration.
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterUserController
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param RegisterUserRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        try {
            $gradeLevel = $request->role === 'user' ? $request->grade_level : null;

            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'grade_level' => $gradeLevel,
                'school' => $request->school,
                'coach_name' => $request->coach_name,
            ]);

            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('dashboard');
        }
        catch (\Throwable $e) {
            \Log::error('User registration failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput($request->except('password'))
                ->withErrors(['register' => 'An error occurred during registration. Please try again later.']);
        }
    }
}
