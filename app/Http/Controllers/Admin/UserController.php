<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Validation\Rule;
use App\Models\User;
use App\Services\Admin\UserService;
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
        return view('admin.users.index', compact('users'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->service->update($user, $request->validated());
        return redirect()->route('admin.users.index')->with('status', 'User updated!');
    }
}
