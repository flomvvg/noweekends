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
        $organizerProfileType = new("App\\Models\\" . ucfirst($event->organizer_profile_type));
        $organizer = $organizerProfileType::find($event->organizer_profile_id);

        return $organizer->users()->exists();
    }

    public function delete(User $user, Event $event): bool
    {
        $organizerProfileType = new("App\\Models\\" . ucfirst($event->organizer_profile_type));
        $organizer = $organizerProfileType::find($event->organizer_profile_id);

        return $organizer->users()->exists();
    }
}
