<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Account;
use App\Models\Invite;

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

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
    public function show() {

        return view('pages.profile', ['account' => Auth::user()]);
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

        if (Auth::user()->admin && Auth::user()->id != $id) return redirect()->route('admin.users');
        return $this->show($account->id);
    }

    public function acceptInvitation($id) {

        
        return redirect()->route('profile');
    }

    public function ignoreInvitation($id, $invite_id) {

        /*
        $invite = Invite::find($invite_id);
        $notification = $invite->notification()->inviteNotification;

        $invite->notification->detach($invite_id);
        $invite->delete();
        */
        return redirect()->route('profile');
        
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
