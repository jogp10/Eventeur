<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\Event;
use App\Models\Ban;
use App\Models\Tag;

class SearchController extends Controller
{
    //
    public function searchEvent()
    {
        $search_text = $_GET['query'];            
        $search_type = $_GET['type'];

        if($search_type == 'name') {
            if (mb_substr($search_text, 0, 1) != "\"") {
                $events = Event::whereFullText('name', $search_text)->get();
                $eventsByDescripton = Event::whereFullText('description', $search_text)->get();
                $eventsByLocation = Event::whereFullText('location', $search_text)->get();
                foreach ($eventsByDescripton as $value) {
                    $events->add($value);
                }
                foreach ($eventsByLocation as $value) {
                    $events->add($value);
                }
            } else {
                $search_text = mb_substr($search_text, 1, strlen($search_text) - 2);
                $events = Event::where('name', 'like', '%' . $search_text . '%')->get();
                $eventsByDescripton = Event::where('description', 'like', '%' . $search_text . '%')->get();
                $eventsByLocation = Event::where('location', 'like', '%' . $search_text . '%')->get();
                foreach ($eventsByDescripton as $value) {
                    $events->add($value);
                }
                foreach ($eventsByLocation as $value) {
                    $events->add($value);
                }
            }
        } else {
            $events = Array();
            $tags = Tag::where('name','=', ucfirst($search_text))->get();
            foreach($tags as $tag) {
                foreach($tag->events as $event) {
                    array_push($events, $event);
                }
            }
        }    
        

        return view('pages.home', ['events' => $events]);
    }

    public function showUser(Request $request)
    {
        if ($_GET['search'] != '') {
            $users = Account::whereRaw('LOWER(name) LIKE ? ', ['%' . strtolower($_GET['search']) . '%'])
                ->where('id', '<>', 1)
                ->get();
        } else {
            $users = Account::All();
            $users->shift();
        }
        foreach ($users as $user) {
            $user->user;
            $user->admin;
            if ($user->admin) $user->admin->bans;
            $user->user->reports;
            $user->user->events;
            $user->updated_at;
            $bans = Ban::where('user_id', $user->id)->get();
            foreach ($bans as $ban) {
                if ($ban->expired_at == null) {
                    $user->banned = true;
                    break;
                }
            }
        }
        return $users;
    }

    public function showAttendee(Request $request)
    {
        if ($_GET['search'] != '') {
            $users = Account::whereRaw('LOWER(name) LIKE ? ', ['%' . strtolower($_GET['search']) . '%'])
                ->where('id', '<>', 1)
                ->get();
        } else {
            $users = Account::All();
            $users->shift();
        }
        $attendees = array();
        foreach ($users as $user) {
            $user->user;
            $user->admin;
            if ($user->admin) $user->admin->bans;
            $user->user->reports;
            $user->user->events;
            $user->updated_at;
            if ($user->user->tickets->where('event_id', $_GET['event_id'])->count() > 0)
                $attendees[] = $user;
        }
        return $attendees;
    }
}
