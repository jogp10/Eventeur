<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\Account  $account
     * @param  string  $ability
     * @return void|bool
     */
    public function before(Account $account)
    {
        if ($account->isBanned())
            return False;
        return null;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Account $account)
    {
        //
        if ($account->admin) return True;
        return False;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?Account $account, Event $event)
    {
        //
        if ($event->privacy == 'Public') return True;
        if ($account == null) return False;
        if ($account->admin) return True;
        if ($account->id == $event->manager->id) return True;
        if ($account->user->invites()->where('event_id', $event->id)->first() != null) return True;
        if ($account->user->tickets()->where('event_id', $event->id)->first()) return True;
        return False;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Account $account)
    {
        //
        return True;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Account $account, Event $event)
    {
        //
        if ($account->admin) return True;
        return $event->manager->id == $account->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Account $account, Event $event)
    {
        //
        if ($account->admin) return True;
        return $event->manager->id == $account->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Account $account, Event $event)
    {
        //
        if ($account->admin) return True;
        return False;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Account $account, Event $event)
    {
        //
        if ($account->admin) return True;
        return False;
    }
}
