<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Account;
use App\Models\Event;
use App\Models\Ban;
use App\Models\Tag;

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

class SearchController extends Controller
{
    //
    public function searchEvent()
    {
        $search_text = $_GET['query'];
        $search_type = $_GET['type'];

        if ($search_type == 'name') {
            if (mb_substr($search_text, 0, 1) != "\"") {
                $events = Event::whereFullText('name', $search_text)->where('privacy', 'Public')->get();
                $eventsByDescripton = Event::whereFullText('description', $search_text)->where('privacy', 'Public')->get();
                $eventsByLocation = Event::whereFullText('location', $search_text)->where('privacy', 'Public')->get();
                foreach ($eventsByDescripton as $value) {
                    if (!$events->contains('id', $value->id)) {
                        $events->add($value);
                    }
                }
                foreach ($eventsByLocation as $value) {
                    /* if value isn't already there */
                    if (!$events->contains('id', $value->id)) {
                        $events->add($value);
                    }
                }
                $events->unique('id');
            } else {
                $search_text = mb_substr($search_text, 1, strlen($search_text) - 2);
                $events = Event::whereRaw('LOWER(name) like LOWER(\'%' . $search_text . '%\')')->where('privacy', 'Public')->get();
                $eventsByDescripton = Event::whereRaw('LOWER(description) like LOWER(\'%' . $search_text . '%\')')->get();
                $eventsByLocation = Event::whereRaw('LOWER(location) like LOWER(\'%' . $search_text . '%\')')->get();
                foreach ($eventsByDescripton as $value) {
                    $events->add($value);
                }
                foreach ($eventsByLocation as $value) {
                    $events->add($value);
                }
            }
        } else {
            $events = collect();
            $tags = Tag::where('name', '=', ucfirst($search_text))->get();
            foreach ($tags as $tag) {
                $events = $events->merge($tag->events);
            }
            $events = $events->unique('id')->where('privacy', 'Public');
        }
        return view('pages.home', ['events' => $events]);
    }

    public function showUser(Request $request)
    {
        if ($_GET['search'] != '') {
            $users = Account::whereRaw('LOWER(name) LIKE ? ', ['%' . strtolower($_GET['search']) . '%'])
                ->where('id', '<>', 1)
                ->where('id', '<>', 102) // admin user
                ->get();
        } else {
            $users = Account::All();
            $users->shift();
            $users->where('id', '<>', 102); // admin user
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

    public function showEvent(Request $request)
    {
        if ($_GET['search'] != '') {
            $events = Event::whereRaw('LOWER(name) LIKE ? ', ['%' . strtolower($_GET['search']) . '%'])
                ->where('id', '<>', 1)
                ->get();
        } else {
            $events = Event::where('privacy', 'Public');
            $events->shift();
        }

        foreach ($events as $event) {
            $event->reports;
            $event->updated_at;
            $event->manager->account->name;
            $event->coverImage->name;
        }
        return $events;
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

    public function searchWithFilter(Request $request)
    {
        $search_text = $_GET['text'];
        $search_tag = $_GET['event_tag'];
        $search_location = $_GET['location'];
        $search_price = $_GET['ticket'];
        $search_start_date = $_GET['start_date'];
        $search_end_date = $_GET['end_date'];
        $search_sort_by = $_GET['sort_by'];
        $search_order_by = $_GET['order_by'];

        $events = Event::where('events.id', '>', 0)->where('privacy', 'Public');


        if ($search_text != '') {
            $events = $events->whereRaw('LOWER(name) LIKE ? ', ['%' . strtolower($search_text) . '%']);
        }

        if ($search_tag != 'Choose category') {
            $events = $events->join('event_tag', 'events.id', '=', 'event_tag.event_id')
                ->where('event_tag.tag_id', '=', $search_tag)
                ->select('events.*');
        }

        if ($search_location != '') {
            $events = $events->whereRaw('LOWER(location) LIKE ? ', ['%' . strtolower($search_location) . '%']);
        }

        if ($search_price != '') {
            $events = $events->where('ticket', '=', $search_price);
        }

        if ($search_start_date != '') {
            $events = $events->where('start_date', '>=', $search_start_date);
        }

        if ($search_end_date != '') {
            $events = $events->where('end_date', '<=', $search_end_date);
        }

        if ($search_sort_by != 'Sort by') {
            if ($search_sort_by == 'start_date' || $search_sort_by == 'end_date' || $search_sort_by == 'ticket' || $search_sort_by == 'location' || $search_sort_by == 'name' || $search_sort_by == 'created_at')
                $events = $events->orderBy($search_sort_by, $search_order_by);
            else if ($search_sort_by == 'comments')
                $events = $events->leftjoin('comments', 'events.id', '=', 'comments.event_id')
                    ->select('events.*')
                    ->orderBy('comments.created_at', $search_order_by);
            else if ($search_sort_by == 'votes')
                $events = $events->leftjoin('votes', 'events.id', '=', 'votes.event_id')
                    ->select('events.*')
                    ->orderBy('votes.created_at', $search_order_by);
            else if ($search_sort_by == 'attendees')
                $events = $events->leftjoin('tickets', 'events.id', '=', 'tickets.event_id')
                    ->select('events.*')
                    ->orderBy('tickets.created_at', $search_order_by);
        }

        $events = $events->get();
        console_log($events);
        return view('pages.home', ['events' => $events]);
    }
}
