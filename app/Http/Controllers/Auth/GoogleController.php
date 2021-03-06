<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instacne.
     * 
     * @return void
     */
    public function handleGoogleCallback(Request $request){
        try {

            //session()->put('state', $request->input('state'));
            $user = Socialite::driver('google')->stateless()->user();

            $findUser = User::where('google_id', $user->id)->first();

            if($findUser) {
                Auth::login($findUser);

                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('test1234')
                ]);

                Auth::login($newUser);

                return redirect('/home');
            }

            $user->token;

        } catch(Exception $e) {
            throw($e);
            dd($e->getMessage());
        }
    }
}
