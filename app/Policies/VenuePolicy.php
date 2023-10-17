<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;

class VenuePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Venue $venue): bool
    {
        return $venue->users()->where('users.id', $user->id)->exists();
    }

    public function delete(User $user, Venue $venue): bool
    {
        return $venue->users()->where('users.id', $user->id)->exists();
    }
}
