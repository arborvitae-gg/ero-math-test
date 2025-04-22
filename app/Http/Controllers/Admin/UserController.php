<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\Admin\UserUpdateRequest;

class UserController
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->service->update($user, $request->validated());
        return redirect()->route('admin.users.index')->with('status', 'User updated!');
    }
}
