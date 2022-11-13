<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CardPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Event $event)
    {
      // Only a event attendee  can see it
      //return $user->id == $event->user_id;
      return True;
    }

    public function list(User $user)
    {
      // Any user can list its own events
      return Auth::check();
    }

    public function create(User $user)
    {
      // Any user can create a new event
      return Auth::check();
    }

    public function delete(User $user, Event $event)
    {
      // Only a event manager can delete it
      return $user->id == $event->user_id;
    }
}
