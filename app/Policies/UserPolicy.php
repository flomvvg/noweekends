<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, User $user2): bool
    {
        return $user->is($user2);
    }

    public function delete(User $user, User $user2): bool
    {
        return $user->is($user2);
    }
}
