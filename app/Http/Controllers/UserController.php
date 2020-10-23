<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\Project;


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

        $users_info = DB::table('users')
                        ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
                        ->select('users.id', 'users.name', 'users.email', 'users.role_id', 'roles.type')
                        ->get();

        $users_roles = DB::table('users')
                        ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
                        ->select('users.name', 'users.id', 'users.email', 'roles.type', 'users.role_id')
                        ->get();

        $users_projects = DB::table('users')
                            ->leftjoin('project_user', 'users.id', 'project_user.user_id')
                            ->leftjoin('projects', 'project_user.project_id', 'projects.id')
                            ->select('projects.title', 'users.id', 'project_user.project_id', 'users.email')
                            ->get();

        return view('user.index', [
            'users' => $users,
            'users_roles' => $users_roles,
            'users_projects' => $users_projects,
            'users_info' => $users_info,
        ]);
    }

    public function update(Request $request) {

        User::where('id', $request->userId)
        ->update(['role_id'=>$request->role_id]);
        print_r($request->input());

        return redirect('/user');
    }

    
}
