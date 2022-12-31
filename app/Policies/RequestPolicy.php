<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Request;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

class RequestPolicy
{
    use HandlesAuthorization;


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
        if($request->event->manager->id == $account->id) {
            return True;
        }
        else {
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
        // Fix this
        if($event->tickets->where('user_id', $account->id)->count() > 0) {
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
        if ($request->user->id == $account->id) {
            return True;
        }
        else {
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
        if($request->event->manager->id == $account->id) {
            return True;
        }
        else {
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
        return False;
    }
}
