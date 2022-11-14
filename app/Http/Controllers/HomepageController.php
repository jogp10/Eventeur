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

        $events = DB::table('events')->whereFullText('name', $search_text)->get(); //->where('name', $search_text);
        return view('pages.home', ['events' => $events]);
    }
}
