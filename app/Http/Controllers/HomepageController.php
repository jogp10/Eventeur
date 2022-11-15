<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class HomepageController extends Controller {

    public function home() {

        $events = DB::table('events')
                ->inRandomOrder()
                ->limit(8)
                ->get();
    
        return view('pages.home', ['events' => $events]);
    }

    public function search(){
        $search_text = $_GET['query'];

        if(mb_substr($search_text, 0,1) == "\""){
            $events = DB::table('events')->whereFullText('name', $search_text)->get();
            $eventsByDescripton = DB::table('events')->whereFullText('description', $search_text)->get();
            $eventsByLocation = DB::table('events')->whereFullText('location', $search_text)->get();
            foreach($eventsByDescripton as $value){
                $events->add($value);
            }
            foreach($eventsByLocation as $value){
                $events->add($value);
            }

        }
        else{
            $events = DB::table('events')->where('name', 'like', '%'.$search_text.'%')->get();
            $eventsByDescripton = DB::table('events')->where('description', 'like', '%'.$search_text.'%')->get();
            $eventsByLocation = DB::table('events')->where('location', 'like', '%'.$search_text.'%')->get();
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
