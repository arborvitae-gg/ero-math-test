<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::where('role', 'user')->get();

        return view('admin.users', compact('users'));
    }
}
