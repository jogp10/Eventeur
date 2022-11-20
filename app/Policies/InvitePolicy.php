<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Invite;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitePolicy
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
    public function viewAny(Account $account)
    {
        //
        return True;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Account $account, Invite $invite)
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
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Account $account, Invite $invite)
    {
        //
        return True;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Account $account, Invite $invite)
    {
        //
        return True;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Account $account, Invite $invite)
    {
        //
        return True;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Account $account, Invite $invite)
    {
        //
        return True;
    }
}
