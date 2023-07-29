<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    /**
     * Create a new policy instance.
     */
    use HandlesAuthorization;

    public function update(User $user, DatabaseNotification $databaseNotification)
    {
        return $user->id === $databaseNotification->notifiable_id;//come from notification DB
    }
}
