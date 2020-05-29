<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;


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

        $users = DB::table('users')
                    ->select('users.id', 'users.name')
                    ->get();

        $users_roles = DB::table('users')
                        ->join('roles', 'roles.id', '=', 'users.role_id')
                        ->select('*')
                        ->get();

        return view('user.index', [
            'users' => $users,
            'users_roles' => $users_roles,
        ]);
    }

    public function update(Request $request) {

        User::where('id', $request->userId)
        ->update(['role_id'=>$request->role_id]);
        //print_r($request->input());

        // $user = User::find($request->userId);
        // $user->role = $request->role;
        // $user->save();

        return redirect('/user');
    }

    
}
