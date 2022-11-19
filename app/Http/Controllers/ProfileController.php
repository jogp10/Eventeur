<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Account;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */

    public function show($id) {

        $account_user = Account::findOrFail($id);

        return view('pages.profile', ['account' => $account_user]);
    }

    public function showEditPage()
    {

        return view('pages.editProfile', ['account' => Auth::user()]);
    }

    public function showSettingsPage()
    {

        return view('pages.securityProfile', ['account' => Auth::user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['max:20'],
            'description' => ['max:200'],
        ]);

        $account = Account::findOrFail($id);

        if ($request['name'] !== null) {
            $account->name = $request['name'];
        }
        if ($request['description'] !== null) {
            $account->description = $request['description'];
        }

        $account->save();
        return $this->show($account->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
    }
}
