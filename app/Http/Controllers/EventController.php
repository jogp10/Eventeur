<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\Event;
use App\Models\Account;
use App\Models\Comment;
use App\Models\UserEventTicket;

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
        $event['manager'] = Account::find($event->user_id)->name;
        console_log($event->manager);
        if ($event->privacy == "Private") {
            $tickets = Ticket::where([['event_id', '=', $id],
            ['user_id', '=', Auth::id()]])->get();

            $this->authorize('view', $event);
        }

        $comments = Event::find($event->id)
            ->comments()
            ->get()
            ->toArray();


        $combined = [];
        foreach ($comments as $comment) {
            $comment['author'] = Account::find($comment['user_id'])->name;
            $answers = Answer::where('comment_id', $comment['id'])->get();

            foreach ($answers as $answer) {
                $answer['author'] = Account::find($answer['user_id'])->name;
            }

            array_push($combined, [$comment, $answers]);
        }

        console_log($combined);

        return view('pages.event', ['event' => $event, 'comments' => $combined]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
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
