<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\Tag;
use App\Models\Account;
use App\Models\CoverImage;

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
            ->where('end_date', '>', date('Y-m-d H:i:s'))
            ->get();

        return view('pages.home', ['events' => $events]);
    }

    public function manageEvents()
    {
        Auth::user();
        $this->authorize('viewAny', Account::class);

        $events = Event::all();
        $events->shift();

        // Check if users are banned

        /*
        foreach ($users as $user) {
            $bans = Ban::where('user_id', $user->id)->get();
            foreach ($bans as $ban) {
                if ($ban->expired_at == null) {
                    $user->banned = true;
                    break;
                }
            }
        }
        */

        if (Auth::user()->admin) return view('pages.admin.events', ['events' => $events]);
        return redirect()->route('home');
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

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('/images/events/', $filename);
            $coverImage = CoverImage::create([
                'name' => $filename,
                'event_id' => $event->id
            ]);
        }

        if ($request->price) $event->price = $request->price;
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

    public function showParticipantsEvent($id)
    {

        $event = Event::find($id);

        $this->authorize('update', $event);

        foreach ($event->invites as $invite) {
            $invite->user;
            $invite->user->account;
        }

        foreach ($event->tickets as $ticket) {
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
    public function edit(Request $request, $id)
    {
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

        $event = Event::find($id);

        $this->authorize('update', $event);

        $validated = $request->validate([
            'name' => ['max:100'],
            'description' => ['max:2000'],
            'tags' => 'required'
        ]);

        if ($request['privacy'] === 'on') {
            $event->privacy = 'Private';
        } else {
            $event->privacy = 'Public';
        }

        $eventTagNames = array();

        foreach ($event->tags as $tag) {
            array_push($eventTagNames, $tag->name);
        }

        foreach ($request->get('tags') as $tagName) {

            if (!in_array($tagName, $eventTagNames)) {
                $tag = Tag::where('name', $tagName)->get();
                $exists = Tag::get()->contains('name', $tagName);

                if (!$exists) {
                    $tag = Tag::create([
                        'name' => $tagName
                    ]);
                }

                $event->tags()->attach($tag);
            }
        }

        foreach ($eventTagNames as $nameTag) {
            if (!in_array($nameTag, $request->get('tags'))) {
                $tag = Tag::where('name', $nameTag)->get();
                $event->tags()->detach($tag);
            }
        }

        if ($request['name'] !== null) {
            $event->name = $request['name'];
        }
        if ($request['description'] !== null) {
            $event->description = $request['description'];
        }
        if ($request['location'] !== null) {
            $event->location = $request['location'];
        }
        if ($request['start_date'] !== null) {
            $event->start_date = $request['start_date'];
        }
        if ($request['end_date'] !== null) {
            $event->end_date = $request['end_date'];
        }
        if ($request['capacity'] !== null) {
            $event->capacity = $request['capacity'];
        }
        if ($request['price'] !== null) {
            $event->price = $request['price'];
        }
        if ($request['image'] !== null) {
            $validate = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/events'), $imageName);

            if ($event->coverImage) {
                $event->coverImage->delete();
            }

            $eventImage = CoverImage::create([
                'event_id' => $event->id,
                'name' => $imageName
            ]);

            $eventImage->save();
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
    public function destroy(Request $request, $id)
    {
        $event = Event::find($id);

        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('home');
    }

}
