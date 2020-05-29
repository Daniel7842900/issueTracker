<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project;
use App\User;

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

        $members = DB::select('select name from users where role = ?', ['manager']);
        //echo $users;

        return view('project.index', [
            'projects' => $projects,
        ]);
    }

    public function create() {

        $managers = DB::select('select name, id from users where role = ?', ['manager']);

        //var_dump($managers);
        $users = DB::select('select * from users where role = ?', ['user']);

        //error_log($users);
        return view('project.create', [
            'managers' => $managers,
            'users' => $users,
        ]);

    }

    public function store(Request $request) {
        print_r($request->input());

        // $project = new Project();

        // $project->name = request('proj_name');
        // $project->desc = request('proj_desc');

        // $project->save();

        //return redirect('/project')->with('mssg', 'Project is created');


    }
}
