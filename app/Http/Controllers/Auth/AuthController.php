<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Validator, Redirect, Response, File;

class AuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
        $user = $this->createUser($getInfo, $provider);
        auth()->login($user);
        return redirect()->route('home');
    }

    function createUser($getInfo, $provider)
    {
        $user = User::where('provider_id', $getInfo->id)->first();
        if (!$user) {
            $user = User::create([
                'name' => $getInfo->name,
                'email' => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);
        }
        return $user;
    }


    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        $user = Socialite::driver('facebook')->user();
        $find_user = User::where('provider_id', $user->id)->first();
        if ($find_user) {
            Auth::login($user);
            return redirect()->route('home');
        }else{
            $new_user = new User();
            $new_user->name = $user->name;
            $new_user->email = $user->email;
            $new_user->phone = $user->phone;
            $new_user->provider = 'facebook';
            $new_user->provider_id = $user->id;
            $new_user->password = Hash::make('123456');
            $new_user->save();

            Auth::login($new_user);
            return redirect()->route('home');
        }
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginWithGoogle()
    {
        $user = Socialite::driver('google')->user();
        $find_user = User::where('provider_id', $user->id)->first();
        if ($find_user) {
            Auth::login($user);
            return redirect()->route('home');
        }else{
            $new_user = new User();
            $new_user->name = $user->name;
            $new_user->email = $user->email;
            $new_user->phone = $user->phone;
            $new_user->provider = 'google';
            $new_user->provider_id = $user->id;
            $new_user->password = Hash::make('123456');
            $new_user->save();

            Auth::login($new_user);
            return redirect()->route('home');
        }
    }
}
