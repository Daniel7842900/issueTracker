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

        //dd($projects);
        
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

        $project->title = request('proj_name');
        $project->description = request('proj_desc');

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
        // print_r($request->input());
        // print_r($id);

        Project::where('id', $id)
                ->update([
                    'title'=>$request->proj_name,
                    'description'=>$request->proj_desc
                    ]);

        $current_manager = DB::table('users')
                                ->leftjoin('roles', 'users.role_id', 'roles.id')
                                ->join('project_user', 'project_user.user_id', 'users.id')
                                ->select('users.id', 'users.name')
                                ->where('users.role_id', '=', 2)
                                ->first();

        //dd($current_manager->id);
        //dd($request->input());

        DB::table('users')
            ->join('project_user', 'project_user.user_id', 'users.id')
            ->where('project_user.user_id', $current_manager->id)
            ->update([
                'project_user.user_id'=>$request->manager
            ]);

        if($request->has('avail_members')) {
            for($i = 0; $i < count($request->avail_members); $i++) {
                DB::table('project_user')
                ->updateOrInsert(
                    ['user_id'=>$request->avail_members[$i]],
                    ['project_id'=>$id]
                );
            }
        } else {
        }
        
        $project = Project::findOrFail($id);

        //dd($project->id);

        if($request->has('cur_members')) {
            for($j = 0; $j < count($request->cur_members); $j++) {
                $project->users()->detach($request->cur_members[$j]);
            }
        } else {
        }
        
        return redirect('/project');
    }

    public function show($id) {

        $project = Project::findOrFail($id);
        //dd($project);
        $assigned_members = DB::table('users')
                                ->leftjoin('roles', 'roles.id', 'users.role_id')
                                ->join('project_user', 'project_user.user_id', 'users.id')
                                ->select('users.name', 'users.email', 'roles.type')
                                ->where('users.role_id', '=', 2)
                                ->orWhere('users.role_id', '=', 3)
                                ->get();

        $project_tickets = DB::table('tickets')
                                ->join('projects', 'projects.id', 'tickets.project_id')
                                ->join('users', 'users.id', 'tickets.submitter_id')
                                ->select('tickets.title', 'tickets.description', 'tickets.created_at', 'users.name', 'tickets.status')
                                ->get();

        //dd($project_tickets);
        
        
        //dd($assigned_members);
        return view('project.show',[
            'project' => $project,
            'assigned_members' => $assigned_members,
            'project_tickets' => $project_tickets,
        ]);
    }

    public function destroy($id) {
        $project = Project::findOrFail($id);
        //dd($project);
        $project->users()->detach();
        $project->delete();

        return redirect('/project');
    }

}
