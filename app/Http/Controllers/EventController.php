<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Ticket;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\Account;

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
        $event['votes'] = Vote::where('event_id', $event->id)->count();

        if ($event->privacy == "Private") {
            $tickets = Ticket::where([
                ['event_id', '=', $id],
                ['user_id', '=', Auth::id()]
            ])->get();

            $this->authorize('view', $event);
        }

        $comments = Event::find($event->id)
            ->comments()
            ->get();

        $combined = [];
        foreach ($comments as $comment) {

            $comment['author'] = Account::find($comment['user_id'])->name;
            $comment['votes'] = Vote::where('comment_id', $comment['id'])->count();

            $answers = Answer::where('comment_id', $comment['id'])->get();
            foreach ($answers as $answer) {
                $answer['author'] = Account::find($answer['user_id'])->name;
                $answer['votes'] = Vote::where('answer_id', $answer['id'])->count();
            }

            array_push($combined, [$comment, $answers]);
        }

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
