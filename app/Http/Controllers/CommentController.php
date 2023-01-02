<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Answer;

class CommentController extends Controller
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
        $event = Event::find($request->event_id);

        $this->authorize('create', [Comment::class, $event]);

        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'event_id' => $event->id,
        ]);

        $comment->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->comment_id;
        $comment = Comment::find($id);

        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('message', 'Comment deleted successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function answerDestroy(Request $request)
    {
        $id = $request->answer_id;
        $answer = Answer::find($id);

        $this->authorize('delete', $answer);

        $answer->delete();

        return redirect()->back()->with('message', 'Answer deleted successfuly.');
    }

    public function answer(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $event = Event::find($comment->event_id);

        $this->authorize('create', [Comment::class, $event]);

        $answer = Answer::create([
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'comment_id' => $comment->id,
        ]);

        $answer->save();

        return redirect()->back();
    }
}
