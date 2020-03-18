<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;



class TwitterAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect()->getTargetUrl();
    }

    public function test_callback($provider)
    {

        $getInfo = Socialite::driver($provider)->user();

        $user = User::where('provider_id', $getInfo->get_provider_Id())->first();

        if (!$user) {
            $user = User::create([
                'name'     => $getInfo->getNickname(),
                'email'    => $getInfo->getEmail(),
                'provider' => $provider,
                'provider_id' => $getInfo->get_provider_Id()
            ]);
        }

        auth()->login($user);

        return redirect()->to('/');

    }

    public function callback($provider)
    {

        $getInfo = Socialite::driver($provider)->user();

        $user = $this->createUser($getInfo,$provider);

        auth()->login($user);

        return redirect()->to('/');

    }

    public function createUser($getInfo,$provider){

        $user = User::where('provider_id', $getInfo->id)->first();

        if (!$user) {
            $user = User::create([
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);
        }

        return $user;
    }

    public function check_user()
    {
        if ( Auth::check() ) {
            $user = Auth::user()->only(['name']);

            return response()->json([ 'user' => $user ]);
        }else{

            abort('404');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->getTargetUrl('login');
    }
}
