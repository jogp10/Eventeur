<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Vote;
use App\Models\Account;
use App\Models\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PollController extends Controller{
    
    public function createPoll(Request $request, $id) {

        $event = Event::find($id);

        $this->authorize('update', $event);

        $validate = $request->validate([
            'question' => 'required' 
        ]);

        $pollOptions = array();
        $request = $request->toArray();
    
        foreach($request as $name => $value) {
            if($value === null) {
                return redirect()->route('event.show', ['id' => $event->id])->with('error', 'You need to fill the options with a answer.');
            }
            
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
}
