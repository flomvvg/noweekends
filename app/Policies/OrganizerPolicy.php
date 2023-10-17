<?php

namespace App\Policies;

use App\Models\Organizer;
use App\Models\User;

class OrganizerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Organizer $organizer): bool
    {
        return $organizer->users()->where('users.id', $user->id)->exists();
    }

    public function delete(User $user, Organizer $organizer): bool
    {
        return $organizer->users()->where('users.id', $user->id)->exists();
    }
}
