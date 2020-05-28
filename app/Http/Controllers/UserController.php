<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::latest()->get();


        //echo $users;

        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function update(Request $request) {

        User::where('id', $request->userId)
        ->update(['role'=>$request->role]);
        //print_r($request->input());

        // $user = User::find($request->userId);
        // $user->role = $request->role;
        // $user->save();

        return redirect('/user');
    }

    
}
