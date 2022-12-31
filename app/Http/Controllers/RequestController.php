<?php

namespace App\Http\Controllers;

use App\Models\Request as Req;
use App\Models\Ticket;
use App\Models\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

class RequestController extends Controller
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
        $event_id = $_POST['event_id'];
        $event = Event::find($event_id);


        $this->authorize('create', [Req::class, $event]);
        
        $user_id = Auth::user()->id;

        $request = Req::create([
            'user_id' => $user_id,
            'event_id' => $event_id
        ]);
        $request->save();

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Req  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Req $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Req  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Req $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Req  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $request_id)
    {
        //
        $this->authorize('create', Ticket::class);

        $request = Req::find($request_id);

        $event = $request->event_id;
        $user_id = $request->user_id;

        $ticket = Ticket::create([
            'user_id' => $user_id,
            'event_id' => $event,
            'num_of_tickets' => 1,
        ]);
        $ticket->save();

        $request = Req::where('user_id', $user_id)->where('event_id', $event)->first();
        $request->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r, $request_id)
    {
        //
        $request = Request::find($request_id);

        $this->authorize('delete', $request);
        
        $request->delete();

        return redirect()->back();
    }
}
