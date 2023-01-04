<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Accout;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AccountPolicy
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
        return $account->admin ? true : null;
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
     * @param  \App\Models\Account  $account2
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?Account $account, Account $account2)
    {
        return $account2->id != 1;
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
        return False;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Accout  $accout
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Account $account, Account $account2)
    {
        //
        return $account->id == $account2->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Accout  $accout
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Account $account, Account $account2)
    {
        //
        return $account->id == $account2->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Account  $account2
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Account $account, Account $account2)
    {
        //
        return False;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Account  $account2
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Account $account, Account $account2)
    {
        //
        return False;
    }
}
