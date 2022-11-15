<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;

class HomepageController extends Controller {

    public function home() {

        $events = Event::inRandomOrder()
                ->limit(8)
                ->get();
    
        return view('pages.home', ['events' => $events]);
    }

    public function search(){
        $search_text = $_GET['query'];

        if(mb_substr($search_text, 0,1) == "\""){
            $events = Event::whereFullText('name', $search_text)->get();
            $eventsByDescripton = Event::whereFullText('description', $search_text)->get();
            $eventsByLocation = Event::whereFullText('location', $search_text)->get();
            foreach($eventsByDescripton as $value){
                $events->add($value);
            }
            foreach($eventsByLocation as $value){
                $events->add($value);
            }

        }
        else{
            $events = Event::where('name', 'like', '%'.$search_text.'%')->get();
            $eventsByDescripton = Event::where('description', 'like', '%'.$search_text.'%')->get();
            $eventsByLocation = Event::where('location', 'like', '%'.$search_text.'%')->get();
            foreach($eventsByDescripton as $value){
                $events->add($value);
            }
            foreach($eventsByLocation as $value){
                $events->add($value);
            }
        }
        
        return view('pages.home', ['events' => $events]);
    }
}
