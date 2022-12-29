<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Ban;
use Illuminate\Auth\Access\HandlesAuthorization;

class BanPolicy
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
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Account $account, Ban $ban)
    {
        //
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
        return $account->admin ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Account $account, Ban $ban)
    {
        //
        return $account->admin ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Account $account, Ban $ban)
    {
        //
        return $account->admin ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Account $account, Ban $ban)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Account $account, Ban $ban)
    {
        //
    }
}
