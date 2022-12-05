<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Comment;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;


class CommentPolicy
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
        return True;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Account $account, Comment $comment)
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
    public function create(Account $account, Event $event)
    {
        //
        return $account->user->tickets->where('event_id', $event->id)->first() != null || $account->id == $event->manager->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Account $account, Comment $comment)
    {
        //
        return $account->id == $comment->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Account $account, Comment $comment)
    {
        //
        return $account->id == $comment->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Account $account, Comment $comment)
    {
        //
        return False;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Account  $account
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Account $account, Comment $comment)
    {
        //
        return False;
    }
}
