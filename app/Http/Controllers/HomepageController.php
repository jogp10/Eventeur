<?php

namespace App\Http\Controllers;


use App\Models\Event;

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

class HomepageController extends Controller
{

    public function home()
    {

        $events = Event::inRandomOrder()
                ->limit(8)
                ->get();

        return view('pages.home', ['events' => $events]);
    }

    public function search()
    {
        $search_text = $_GET['query'];

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

        return view('pages.home', ['events' => $events]);
    }
}
