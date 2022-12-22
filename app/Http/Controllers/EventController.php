<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\Invite;
use App\Models\Ticket;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Vote;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

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
        $event = new Event();

        $this->authorize('create', $event);

        return view('pages.createEvent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event();

        $this->authorize('create', $event);

        $event->name = $request->name;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->capacity = $request->capacity;
        $event->privacy = $request->privacy;
        $event->user_id = Auth::user()->id;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/events/', $filename);
            $event->image = $filename;
        }

        if($request->price) $event->price = $request->price;
        $event->save();

        return redirect()->route('event.show', ['id' => $event->id]);
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

    public function createPoll(Request $request, $id) {

        $event = Event::find($id);

        $this->authorize('update', $event);

        $request = $request->toArray();
        $pollOptions = array();
    
        foreach($request as $name => $value) {
            echo $name;
            if(strpos($name, "option") !== false) {
                $pollOptions[$name] = $value;
            }
        }
        
        $question = $request['question'];

        $poll = Poll::create([
            'event_id' => $event->id,
            'question' => $question
        ]);
        
        for($i = 1; $i <= sizeof($pollOptions); $i++) {
            $pollOption = PollOption::create([
                'poll_id' => $poll->id,
                'description' => $pollOptions['option' . $i],
            ]);
        }

        return redirect()->route('event.show', ['id' => $event]);
    }

    function votePoll(Request $request, $id) {

        $pollOption = PollOption::find($request['pollOption']);
        $poll = Poll::find($id);
        $user = Account::find(Auth::id());

        $votes = Vote::where('user_id', '=', Auth::id())->get();

        if($votes !== null) {
            foreach($votes as $vote) {
                $option = PollOption::find($vote->poll_option_id);
                if($pollOption->id === $vote->poll_option_id) {
                    return redirect()->route('event.show', ['id' => $poll->event_id]);
                }else if($option->poll_id === $poll->id) {
                    return redirect()->route('event.show', ['id' => $poll->event_id]);
                }
            }
        }

        $vote = Vote::create([
            'user_id' => Auth::id(),
            'poll_option_id' => $pollOption->id,
            'event_id' => $poll->event_id
        ]);

        $pollOption->increment('votes');

        return redirect()->route('event.show', ['id' => $poll->event_id]);
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
            'tags' => 'required'
        ]);

        if($request['privacy'] == 'on') {
            $event->privacy = 'Private';
        }else {
            $event->privacy = 'Public';
        }

        foreach($request->get('tags') as $tagName) {

            $tag = Tag::where('name', $tagName)->get();
            $exists = Tag::get()->contains('name', $tagName);

            if(!$exists) {
                $tag = Tag::create([
                    'name' => $tagName
                ]);
                
                $event->tags()->attach($tag);
            }

        }

        if ($request['name'] !== null) {
            $event->name = $request['name'];
        }
        if ($request['description'] !== null) {
            $event->description = $request['description'];
        }

        $event->save(); 
        return redirect()->route('event.show', ['id' => $event]);
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
        
    }

    public function deleteInvite(Request $request)
    {
        
    }
}
