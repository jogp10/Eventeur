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
}
