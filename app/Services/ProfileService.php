<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    /**
     * Update the user's profile information.
     *
     * @param User $user
     * @param array $validatedData
     * @return void
     */
    public function updateProfile(User $user, array $validatedData): void
    {
        $user->fill($validatedData);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
    }

    /**
     * Delete the user's account after validating password.
     *
     * @param User $user
     * @param Request $request
     * @return void
     */
    public function deleteProfile(User $user, Request $request): void
    {
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
