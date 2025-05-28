<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Validation\Rule;
use App\Models\User;
use App\Services\Admin\UserService;
use App\Http\Requests\Admin\UserUpdateRequest;

/**
 * Controller for managing users in the admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class UserController
{
    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected $service;

    /**
     * Inject UserService dependency.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of users with the 'user' role.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $this->service->update($user, $request->validated());
            return redirect()->route('admin.users.index')->with('status', 'User updated!');
        }
        catch (\Throwable $e) {
            \Log::error('User update failed', ['user_id' => $user->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to update user. Please try again.');
        }
    }
}
