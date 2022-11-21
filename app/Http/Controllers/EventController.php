<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Invite;
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
        $events = Event::inRandomOrder()
            ->limit(8)
            ->where('privacy', 'Public')
            ->get();

        return view('pages.home', ['events' => $events]);
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

        $this->authorize('view', $event);

        return view('pages.event', ['event' => $event]);
    }

    public function showParticipantsEvent($id) {
        
        $event = Event::find($id);

        $this->authorize('update', $event);

        foreach($event->invites as $invite) {
            $invite->user;
            $invite->user->account;
        }

        foreach($event->tickets as $ticket) {
            $ticket->user;
            $ticket->user->account;
        }

        return view('pages.eventParticipants', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $event = Event::find($id);

        $this->authorize('update', $event);

        return view('pages.eventSettings', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $event = Event::find($id);

        $this->authorize('update', $event);

        $validated = $request->validate([
            'name' => ['max:100'],
            'description' => ['max:2000'],
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
        return view('pages.event', ['event' => $event]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $event = Event::find($id);

        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('home');
    }

    public function invite(Request $request)
    {
        $this->authorize('create', Invite::class);

        $users_id = $_POST['ids'];
        $event = $_POST['event_id'];
        $users_id = explode(',', $users_id);
        foreach ($users_id as $user_id) {
            $invite = Invite::create([
                'user_id' => $user_id,
                'event_id' => $event,
            ]);
            $invite->save();
        }

        return response()->json(['success' => true]);
    }

    public function deleteInvite(Request $request)
    {
        $invite = Invite::find($request['id']);

        $this->authorize('delete', $invite);
        
        $invite->delete();

        return redirect()->back();
    }

    public function ticket(Request $request)
    {
        $this->authorize('create', Ticket::class);

        $users_id = $_POST['ids'];
        $event = $_POST['event_id'];
        $users_id = explode(',', $users_id);
        foreach ($users_id as $user_id) {
            $ticket = Ticket::create([
                'user_id' => $user_id,
                'event_id' => $event,
                'num_of_tickets' => 2,
            ]);
            $ticket->save();
        }

        return response()->json(['success' => true]);
    }

    public function deleteTicket(Request $request)
    {
        $ticket = Ticket::find($request['id']);

        $this->authorize('delete', $ticket);
        
        $ticket->delete();

        return redirect()->back();
    }
}
