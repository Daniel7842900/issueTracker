<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project;
use App\User;
use App\Role;

class ProjectController extends Controller
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
        $projects = Project::latest()->get();

        // $members = DB::select('select name from users where role = ?', ['manager']);
        //echo $users;

        return view('project.index', [
            'projects' => $projects,
        ]);
    }

    public function create() {

        $managers = DB::table('users')
                        ->leftjoin('roles', 'users.role_id', 'roles.id')
                        ->select('users.id', 'users.name')
                        ->where('users.role_id', '=', 2)
                        ->get();
        
        //var_dump($managers);
        $users = DB::table('users')
                    ->leftjoin('roles', 'users.role_id', 'roles.id')
                    ->select('users.id', 'users.name')
                    ->where('users.role_id', '=', 3)
                    ->get();

        //error_log($users);
        return view('project.create', [
            'managers' => $managers,
            'users' => $users,
        ]);

    }

    public function store(Request $request) {
        //print_r($request->input());

        $project = new Project();

        $project->name = request('proj_name');
        $project->desc = request('proj_desc');

        $project->save();
        $currentId = $project->id;

        $manager = request('manager');
        $users = request('members');
        
        // echo "this is id";
        // echo($currentId);
        // echo "this is cur proj";
        // echo($current_Project);
        // var_dump($users);

        foreach($users as $user) {
            echo "this is single user";
            echo $user;
            $current_Project = Project::findOrFail($currentId);
            $current_Project->users()->attach($user);
        }

        

        // $project->save();

        //return redirect('/project')->with('mssg', 'Project is created');


    }
}
