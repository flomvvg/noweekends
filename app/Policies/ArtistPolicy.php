<?php

namespace App\Policies;

use App\Models\User;

class ArtistPolicy
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
        return $user->artists()->exists();
    }

    public function delete(User $user): bool
    {
        return $user->artists()->exists();
    }
}
