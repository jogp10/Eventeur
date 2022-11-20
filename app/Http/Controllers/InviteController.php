<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    //
    public function invite(Request $request)
    {
        $users_id = $_POST['ids'];
        $event = $_POST['event_id'];
        $users_id = explode(',', $users_id);

        foreach ($users_id as $user_id) {
            $invite = Invite::create([
                'user_id' => $user_id,
                'event_id' => $event,
            ]);

            $invite->save();
        }

        return response()->json(['success' => true]);
    }

    public function accept($id) {




        return view('pages.profile');
    }
}
