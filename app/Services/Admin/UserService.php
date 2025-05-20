<?php

namespace App\Services\Admin;

use App\Models\User;

class UserService
{
    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
}
