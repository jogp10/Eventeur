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
        return $account->admin() ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(?Account $account)
    {
        //
        return True;
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
        return True;
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
        return $event->manager === $account->id;
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
        return $event->manager === $account->id;
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
        return False;
    }
}
