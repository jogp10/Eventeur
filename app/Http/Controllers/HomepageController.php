<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomepageController extends Controller {

    public function home() {

        $events = DB::table('events')
                ->inRandomOrder()
                ->limit(8)
                ->get();
        
        
        return view('pages.home', ['events' => $events]);
    }
}
