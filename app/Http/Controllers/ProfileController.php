<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show() {

        print_r(Auth::user()->user);

        return view('pages.profile', ['account' => Auth::user()]);
    }

    public function showEditPage() {

        return view('pages.editProfile', ['account' => Auth::user()]);
    }

    public function showSettingsPage() {

        return view('pages.securityProfile', ['account' => Auth::user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $validated = $request->validate([
            'name' => ['unique:account','max:20'],
            'description' => ['max:200'],
        ]);
        
        if($request['name'] !== null) {
            Auth::user()->name = $request['name'];
        }
        if($request['description'] !== null) {
            Auth::user()->description = $request['description'];
        }

        Auth::user()->save();
        return view('pages.profile', ['account' => Auth::user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account) {
        
    }
}
