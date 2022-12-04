<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Account;
use App\Models\Invite;
use App\Models\User;
use App\Models\Ticket;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user();
        $this->authorize('viewAny', Account::class);

        $users = Account::all();
        $users->shift();

        if (Auth::user()->admin) return view('pages.admin.users', ['users' => $users]);
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account_user = Account::find($id);

        $this->authorize('view', $account_user);

        return view('pages.profile', ['account' => $account_user]);
    }

    public function showEditPage($id)
    {
        $account_user = Account::find($id);

        $this->authorize('update', $account_user);

        if (Auth::user()->admin && Auth::user()->id != $id) return view('pages.admin.editUser', ['account' => $account_user]);
        return view('pages.editProfile', ['account' => $account_user]);
    }

    public function showSettingsPage($id)
    {
        $account_user = Account::find($id);

        $this->authorize('update', $account_user);

        if (Auth::user()->admin && Auth::user()->id != $id) return view('pages.admin.editUser', ['account' => $account_user]);
        return view('pages.securityProfile', ['account' => $account_user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $account = Account::find($id);

        $this->authorize('update', $account);

        $validated = $request->validate([
            'name' => ['max:20'],
            'description' => ['max:200'],
        ]);

        if ($request['name'] !== null) {
            $account->name = $request['name'];
        }
        if ($request['description'] !== null) {
            $account->description = $request['description'];
        }

        $account->save();

        if (Auth::user()->admin && Auth::id() != $id) return redirect()->route('admin.users');
        return $this->show($account->id);
    }

    public function acceptInvitation($id, $invite_id) {

        $user = User::find($id);
        $invite = Invite::find($invite_id);
        $event = $invite->event;

        $this->authorize('delete', $invite);
        
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'num_of_tickets' => 1
        ]);

        $invite->delete();
        return redirect()->route('profile', $id);
    }

    public function ignoreInvitation($id, $invite_id) {

        $invite = Invite::find($invite_id);

        $this->authorize('delete', $invite);

        $invite->delete();

        return redirect()->route('profile', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Account::find($id);

        $this->authorize('delete', $user);

        $user->delete();

        if (Auth::user()->admin && Auth::user()->id != $id) return redirect()->route('admin.users');
        return redirect()->route('home');
    }
}
