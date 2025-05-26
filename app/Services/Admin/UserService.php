<?php

namespace App\Services\Admin;

use App\Models\User;

/**
 * Service for admin user management logic.
 *
 * @package App\Services\Admin
 */
class UserService
{
    /**
     * Update a user's data as an admin.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User
    {
        try {
            $user->update($data);
            return $user;
        } catch (\Throwable $e) {
            \Log::error('Admin user update failed', ['user_id' => $user->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}
