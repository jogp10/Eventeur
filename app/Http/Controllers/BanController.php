<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Ban;
use App\Models\Account;

class BanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Account::find($request->user_id);

        $this->authorize('create', Ban::class);

        $ban = Ban::create([
            'user_id' => $request->user_id,
            'admin_id' => Auth::user()->admin->id,
            'reason' => 'You have been banned by an administrator.'
        ]);

        return redirect()->back()->with('message', 'User has been banned.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function show(Ban $ban)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function edit(Ban $ban)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ban $ban)
    {
        //
        $this->authorize('create', Ban::class);

        $bans = Ban::where('user_id', $request->user_id)->get();
        if ($bans) {
            foreach ($bans as $ban) {
                if ($ban->expired_at == null) {
                    $ban->expired_at = now();
                    $ban->save();
                }
            }
        }

        return redirect()->back()->with('message', 'User has been unbanned.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ban $ban)
    {
        //
    }
}
