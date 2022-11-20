<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Event;
use App\Models\Account;

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

class EventController extends Controller
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
    public function show($id)
    {
        $event = Event::find($id);

        if ($event->privacy == "Private") {

            $this->authorize('view', $event);
        }

        return view('pages.event', ['event' => $event]);
    }

    public function showEditEvent($id) {
        
        $event = Event::find($id);

        return view('pages.eventSettings', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

        $event = Event::find($id);

        $validated = $request->validate([
            'name' => ['max:20'],
            'description' => ['max:2000'],
            'tags' => 'required'
        ]);

        //print_r($request['privacy']);

        //if($request['privacy'] == 'on') {
        //    $event->privacy = Privacy::public;
        //}else {
        //    $event->privacy = Privacy::private;
        //}

        //print_r($request->get('tags'));

        //foreach($request->get('tags') as $tag) {
        //    $event->tags()->attach($tag);
        //}

        
        if ($request['name'] !== null) {
            $event->name = $request['name'];
        }
        if ($request['description'] !== null) {
            $event->description = $request['description'];
        }

        $event->save(); 
        return $this->show($id);
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
    public function destroy($id) {
        
        /*
        $event = Event::find($id);
        $manager = User::find($event->manager->id);
        
        DB::table('event_tags')->where('event_id', $id)->delete();
        $manager->detach($id);

        $event->erase();
        $event->save();
        */
        

        return view('pages.profile');
    }
}
