<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Request;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
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
        if ($account->admin) return True;
        return True;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Account $account, Request $request)
    {
        if ($account->admin) return True;
        if ($request->event->manager->id == $account->id) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Account $account, Event $event)
    {
        if ($account->admin) return False;
        if ($event->tickets->where('user_id', $account->id)->count() > 0) {
            return False;
        } else if (Request::where('event_id', $event->id)->exists() && Request::where('event_id', $event->id)->where('user_id', $account->id)->count() > 0) {
            return False;
        } else if ($event->manager->id == $account->id) {
            return False;
        } else {
            return True;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Account $account, Request $request)
    {
        if ($account->admin) return True;
        if ($request->user->id == $account->id) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Account $account, Request $request)
    {
        if ($account->admin) return True;
        if ($request->event->manager->id == $account->id) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Account $account, Request $request)
    {
        if ($account->admin) return True;
        return False;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Account $account, Request $request)
    {
        if ($account->admin) return True;
        return False;
    }
}
