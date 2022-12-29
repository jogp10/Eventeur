<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Account;



class OAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        $authUser = Account::updateOrCreate(
            [
                'provider_id' => $user->id,
                'provider' => 'google'
            ],
            [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'provider_token' => $user->token,
                'provider_refresh_token' => $user->refreshToken,
                'provider' => 'google',
            ]
        );

        Auth::login($authUser);

        return redirect()->route('profile', ['id' => $authUser->id]);
    }
}
