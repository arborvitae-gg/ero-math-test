<?php

namespace App\Policies;

use App\Models\User;

/**
 * Policy for user role-based authorization.
 *
 * @package App\Policies
 */
class RolePolicy
{
    /**
     * Determine if the user has the given role.
     *
     * @param User $user
     * @param string $role
     * @return bool
     */
    public function hasRole(User $user, string $role): bool
    {
        return $user->role === $role;
    }
}
