<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display About page.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('pages.static.about');
    }

    /**
     * Display Contact us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        return view('pages.static.contactus');
    }

    /**
     * Display FAQs page.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq()
    {
        return view('pages.static.faq');
    }
}
