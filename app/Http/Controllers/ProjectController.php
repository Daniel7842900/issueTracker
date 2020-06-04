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
        $projects = Project::with(['users'])->get();

        //dd($projects->users);
        
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
        $current_Project = Project::findOrFail($currentId);
        $current_Project->users()->attach($manager);

        foreach($users as $user) {
            echo "this is single user";
            echo $user;
            // $current_Project = Project::findOrFail($currentId);
            $current_Project->users()->attach($user);
        }

        

        // $project->save();

        return redirect('/project')->with('mssg', 'Project is created');
    }

    public function edit($id) {
        $project = Project::findOrFail($id);

        $managers = DB::table('users')
                        ->leftjoin('roles', 'users.role_id', 'roles.id')
                        ->select('users.id', 'users.name')
                        ->where('users.role_id', '=', 2)
                        ->get();

        $available_users = DB::table('users')
                    ->leftjoin('roles', 'users.role_id', 'roles.id')
                    ->leftjoin('project_user', 'project_user.user_id', 'users.id')
                    ->select('users.id', 'users.name', 'project_user.project_id')
                    ->where('users.role_id', '=', 3)
                    ->whereNull('project_user.project_id')
                    ->get();

        //dd($users);

        $current_users = DB::table('users')
                            ->leftjoin('roles', 'users.role_id', 'roles.id')
                            ->join('project_user', 'project_user.user_id', 'users.id')
                            ->select('users.id', 'users.name')
                            ->where('users.role_id', '=', 3)
                            ->where('project_user.project_id', '=', $id)
                            ->get();

        //dd($current_users);

        return view('project.edit', [
            'project' => $project,
            'managers' => $managers,
            'available_users' => $available_users,
            'current_users' => $current_users,
        ]);
    }
    
    public function update(Request $request, $id) {
        print_r($request->input());
        print_r($id);

        Project::where('id', $id)
                ->update([
                    'name'=>$request->proj_name,
                    'desc'=>$request->proj_desc
                    ]);

        $current_manager = DB::table('users')
                                ->leftjoin('roles', 'users.role_id', 'roles.id')
                                ->join('project_user', 'project_user.user_id', 'users.id')
                                ->select('users.id', 'users.name')
                                ->where('users.role_id', '=', 2)
                                ->first();

        //dd($current_manager->id);
        //dd($request->members);

        DB::table('users')
            ->join('project_user', 'project_user.user_id', 'users.id')
            ->where('project_user.user_id', $current_manager->id)
            ->update([
                'project_user.user_id'=>$request->manager
            ]);

        for($i = 0; $i < count($request->members); $i++) {
            DB::table('project_user')
            ->updateOrInsert(
                ['user_id'=>$request->members[$i]],
                ['project_id'=>$id]
            );
        }

        return redirect('/project');

    }
}
