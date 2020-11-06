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

        $trashed_projects = Project::onlyTrashed()->latest()->get();

        //dd($trashed_projects);
        
        return view('project.index', [
            'projects' => $projects,
            'trashed_projects' => $trashed_projects
        ]);
    }

    public function create() {

        $managers = DB::table('users')
                        ->leftjoin('roles', 'users.role_id', 'roles.id')
                        ->select('users.id', 'users.name')
                        ->where('users.role_id', '=', 2)
                        ->get();
        
        $users = DB::table('users')
                    ->leftjoin('roles', 'users.role_id', 'roles.id')
                    ->select('users.id', 'users.name')
                    ->where('users.role_id', '=', 3)
                    ->get();

        return view('project.create', [
            'managers' => $managers,
            'users' => $users,
        ]);

    }

    public function store(Request $request) {

        // Activating authorization for creating a project
        $this->authorize('create', Project::class);

        // Validating data request for creating a project
        $data = request()->validate([
            'title' => 'required|min:5|max:50',
            'description' => 'required|min:5|max:100'
        ]);

        $project = Project::create($data);
        
        $currentId = $project->id;

        $manager = request('manager');
        $users = request('members');
        
        $current_Project = Project::findOrFail($currentId);
        $current_Project->users()->attach($manager);

        // If a member/members are selected, assign to a specific project
        if($request->has('members')) {
            foreach($users as $user) {
                $current_Project->users()->attach($user);
            }
        } else {

        }

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

        $current_users = DB::table('users')
                            ->leftjoin('roles', 'users.role_id', 'roles.id')
                            ->join('project_user', 'project_user.user_id', 'users.id')
                            ->select('users.id', 'users.name')
                            ->where('users.role_id', '=', 3)
                            ->where('project_user.project_id', '=', $id)
                            ->get();

        return view('project.edit', [
            'project' => $project,
            'managers' => $managers,
            'available_users' => $available_users,
            'current_users' => $current_users,
        ]);
    }
    
    public function update(Request $request, $id) {

        // Validating data request for updating a project
        request()->validate([
            'title' => 'required|min:5|max:50',
            'description' => 'required|min:5|max:100'
        ]);
        
        $project = Project::findOrFail($id);

        // Activating authorization for updating a project
        $this->authorize('update', $project);

        Project::where('id', $id)
                ->update([
                    'title'=>$request->title,
                    'description'=>$request->description
                    ]);

        $current_manager = DB::table('users')
                                ->join('project_user', 'project_user.user_id', 'users.id')
                                ->select('users.id', 'users.name')
                                ->where('project_user.project_id', $project->id)
                                ->first();

        if($request->has('manager')) {
            DB::table('users')
            ->join('project_user', 'project_user.user_id', 'users.id')
            ->where('project_user.user_id', $current_manager->id)
            ->where('project_user.project_id', $project->id)
            ->update([
                'project_user.user_id'=>$request->manager
            ]);
        }
        
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

        //this project->users works!
        //dd($project->users);
        
        $assigned_members = DB::table('users')
                                ->leftjoin('roles', 'roles.id', 'users.role_id')
                                ->leftjoin('project_user', 'project_user.user_id', 'users.id')
                                ->select('*')
                                ->where('project_user.project_id', '=', $id)
                                ->where('users.role_id', '!=', 1)
                                ->get();

        $project_tickets = DB::table('tickets')
                                ->join('projects', 'projects.id', 'tickets.project_id')
                                ->join('users', 'users.id', 'tickets.submitter_id')
                                ->select('tickets.title', 'tickets.description', 'tickets.created_at', 'users.name', 'tickets.status', 'projects.id')
                                ->get();

        return view('project.show',[
            'project' => $project,
            'assigned_members' => $assigned_members,
            'project_tickets' => $project_tickets,
        ]);
    }

    public function softDelete($id) {

        $project = Project::findOrFail($id);

        // Activating authorization for deleting a project
        $this->authorize('delete', $project);

        //$project->users()->detach();
        $project->delete();

        return redirect('/project');
    }

    public function forceDelete($id) {

        $project = Project::onlyTrashed()->findOrFail($id);

        // Activating authorization for deleting a project
        $this->authorize('delete', $project);

        $project->users()->detach();
        $project->forceDelete();

        return redirect('/project');
    }

    public function restore($id) {

        Project::onlyTrashed()->find($id)->restore();

        return redirect('/project');

    }

}
