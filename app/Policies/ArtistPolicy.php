<?php

namespace App\Policies;

use App\Models\Artist;
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
    public function edit(User $user, Artist $artist): bool
    {
        return $artist->users()->where('users.id', $user->id)->exists();
    }
    public function delete(User $user, Artist $artist): bool
    {
        return $artist->users()->where('users.id', $user->id)->exists();
    }
}
