<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Validation\Rule;
use App\Models\User;

/**
 * Controller for managing users in the admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class UserController
{
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
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('status', 'User deleted!');
        } catch (\Throwable $e) {
            \Log::error('User delete failed', ['user_id' => $user->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Failed to delete user. Please try again.');
        }
    }
}
