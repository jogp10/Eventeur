<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\Event;
use App\Models\Account;
use App\Models\Comment;

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
        console_log($event->manager);
        if ($event->privacy == "Private") {
            $tickets = DB::table('userticketevent')
                ->where('event_id', $id)
                ->get();

            $this->authorize('view', $event);
        }

        $comments = Event::find($event->id)
            ->comments()
            ->get()
            ->toArray();


        $comments = array_filter($comments, function ($comment) {
            if (Answer::where('answer_id', $comment['id'])->get()->count() == 0) {
                return true;
            }
            return false;
        });


        $combined = [];
        foreach ($comments as $comment) {
            $ids = Answer::where('comment_id', $comment['id'])->get();
            $answers = [];
            $comment['author'] = Account::find($comment['user_id'])->name;
            $comment['edited'] = $comment['edited'] ? "edited" : "";
            foreach ($ids as $id) {
                $answer = Comment::find($id->answer_id);
                $answer['author'] = Account::find($answer->user_id)->name;
                $answer['edited'] = $answer['edited'] ? "edited" : "";
                array_push($answers, $answer);
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
