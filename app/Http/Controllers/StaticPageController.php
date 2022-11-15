<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StaticPageController extends Controller
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
        return view('pages.static.contact');
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

    /**
     * Submit Contact Request.
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'content' => 'required',
        ]);

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        );

        
        return redirect()->back()->with('message', 'Your message has been sent successfully!');
    }
}
