<?php

namespace App\Policies;

use App\Models\User;

class VenuePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user): bool
    {
        return $user->venues()->exists();
    }

    public function delete(User $user): bool
    {
        return $user->venues()->exists();

    }
}
