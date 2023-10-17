<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Event $event): bool
    {
        $organizer = $event->organizerProfile();

        return $organizer->users()->where('users.id', $user->id)->exists();
    }

    public function delete(User $user, Event $event): bool
    {
        $organizer = $event->organizerProfile();

        return $organizer->users()->where('users.id', $user->id)->exists();
    }
}
