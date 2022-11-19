<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function home() {
        if(Auth::user()->admin) {
            return view('pages.admin.home');
        } else {
            return redirect()->route('home');
        }
    }

    public function users() {
        if(Auth::user()->admin) {
            $users = Account::all();
            $users->shift();
            return view('pages.admin.users', ['users' => $users]);
        } else {
            return redirect()->route('home');
        }
    }

    public function user($id) {
        if(Auth::user()->admin) {
            $user = Account::findOrFail($id);
            return view('pages.admin.user', ['user' => $user]);
        } else {
            return redirect()->route('home');
        }
    }

    public function editUser($id) {
        if(Auth::user()->admin) {
            $user = Account::findOrFail($id);
            return view('pages.admin.editUser', ['account' => $user]);
        } else {
            return redirect()->route('home');
        }
    }

    public function updateUser(Request $request, $id) {
        if(Auth::user()->admin) {
            $validated = $request->validate([
                'name' => ['max:20'],
                'description' => ['max:200'],
            ]);

            $user = Account::findOrFail($id);
            $user->name = $request->name;
            $user->description = $request->description;
            $user->save();
            return redirect()->route('admin.users');
        } else {
            return redirect()->route('home');
        }
    }

    public function deleteUser($id) {
        if(Auth::user()->admin) {
            $user = Account::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.users');
        } else {
            return redirect()->route('home');
        }
    }




}
