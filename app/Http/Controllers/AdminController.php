<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Admin;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Ban;

class AdminController extends Controller
{
    //

    public function index()
    {
        $this->authorize('viewAny', Account::class);

        if (Auth::user()->admin) {
            return view('pages.admin.home');
        } else {
            return redirect()->route('home');
        }
    }

    public function createAccount()
    {
        $this->authorize('create', Account::class);

        if (Auth::user()->admin) {
            return view('pages.admin.createAccount');
        } else {
            return redirect()->route('home');
        }
    }

    public function storeAccount(Request $request)
    {

        $this->authorize('create', Account::class);

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:accounts',
            'password' => 'required|string|min:6',
        ]);
        $validator->validate();

        $account = Account::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if (array_key_exists('admin', $data) != null) {
            $admin = Admin::create([
                'account_id' => $account['id']
            ]);
            $admin->save();
        }

        $account->save();

        return redirect()->route('admin.users');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:accounts',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Account
     */
    protected function create(array $data)
    {
        $account = Account::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        return $account;
    }
}
