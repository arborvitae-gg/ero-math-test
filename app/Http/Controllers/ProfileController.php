<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\ProfileService;

class ProfileController
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $this->profileService->updateProfile($request->user(), $request->validated());
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Throwable $e) {
            \Log::error('User profile update failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return Redirect::route('profile.edit')->withErrors(['profile' => 'An error occurred while updating your profile. Please try again later.']);
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        try {
            $this->profileService->deleteProfile($request->user(), $request);
            return Redirect::to('/');
        } catch (\Throwable $e) {
            \Log::error('User profile deletion failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return Redirect::route('profile.edit')->withErrors(['profile' => 'An error occurred while deleting your account. Please try again later.']);
        }
    }
}
