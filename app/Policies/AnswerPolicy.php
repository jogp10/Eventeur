<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Answer;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

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
        return True;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Account $account, Answer $answer)
    {
        //
        if ($account->admin) return True;
        return True;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Account $account, Event $event)
    {
        //
        if ($account->admin) return False;
        return $account->user->tickets->where('event_id', $event->id)->first() != null || $account->id == $event->manager->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Account $account, Answer $answer)
    {
        //
        if ($account->admin) return True;
        return $account->id == $answer->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Account $account, Answer $answer)
    {
        //
        if ($account->admin) return True;
        return $account->id == $answer->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Account $account, Answer $answer)
    {
        //
        if ($account->admin) return True;
        return False;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Account $account, Answer $answer)
    {
        //
        if ($account->admin) return True;
        return False;
    }
}
