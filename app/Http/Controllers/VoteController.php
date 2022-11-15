<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Submit a Vote.
     *
     * @return \Illuminate\Http\Response
     */
    public function vote()
    {
        $action = $_GET['action'];
        $id = $_GET['id'];
        $user_id = $_GET['user_id'];
        $type = $_GET['type'];
        
        Vote::where('user_id', $user_id)->where($type.'_id', $id)->count() > 0 ? $vote = Vote::where('user_id', $user_id)->where($type.'_id', $id)->first() 
                : $vote = Vote::create(['user_id' => $user_id, $type.'_id' => $id]);

        if ($action == 'down')
        {
            $vote->delete();
        }
        return redirect()->back()->with('message', 'Your vote has been set successfully!');;
    }
}
