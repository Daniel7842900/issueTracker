<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Ticket;
use App\Project;


class TicketController extends Controller
{
    public function index() {
        $tickets = DB::table('tickets')
                        ->join('projects', 'tickets.project_id', 'projects.id')
                        //->leftjoin('project_user', 'projects.id', 'project_user.project_id')
                        ->select('tickets.title', 'tickets.description', 'tickets.assignee_id',
                        'tickets.priority', 'tickets.status', 'tickets.created_at', 'tickets.updated_at',
                        'tickets.submitter_id', 'tickets.type', 'tickets.project_id', 'tickets.id')
                        ->get();

        $project_users = DB::table('project_user')
                            ->get();

        //dd($project_user);
        //dd($tickets);

        // $project = DB::table('projects')
        //                 ->join('tickets', 'tickets.project_id', 'projects.id')
        //                 ->select('projects.title')
        //                 ->first();

        $projects = Project::with(['users'])->get();
        // $projects = DB::table('projects')
        //                 ->join('tickets', 'tickets.project_id', 'projects.id')
        //                 ->select('projects.title')
        //                 ->get();

        //dd($projects);
        
        $submitters = DB::table('users')
                        ->join('tickets', 'tickets.submitter_id', 'users.id')
                        ->select('users.name', 'tickets.submitter_id', 'tickets.id')
                        ->get();

        
        $assignees = DB::table('users')
                        ->join('tickets', 'tickets.assignee_id', 'users.id')
                        ->select('tickets.id', 'users.name')
                        ->get();

        //dd($submitters);
        //dd($assignees);

        return view('ticket.index', [
            'tickets' => $tickets,
            'project_users' => $project_users,
            'projects' => $projects,
            'submitters' => $submitters,
            'assignees' => $assignees,
        ]);
    }

    public function create() {

        $projects = DB::table('projects')
                        ->get();

        //dd($projects);

        return view('ticket.create',[
            'projects' => $projects,
        ]);
    }

    public function store(Request $request) {
        $ticket = new Ticket();

        //dd($request->input());
        $ticket->title = request('ticket_title');
        $ticket->description = request('ticket_desc');
        $ticket->project_id = request('ticket_project');
        $ticket->type = request('ticket_type');
        $ticket->priority = request('ticket_priority');

        $user_id = Auth::id();
        //dd($user_id);

        $ticket->submitter_id = $user_id;
        $ticket->status = 'open';
        $ticket->save();

        return redirect('/ticket');
    }

    public function edit($id) {
        $ticket = Ticket::findOrFail($id);

        $projects = DB::table('projects')
                        ->get();

        $cur_assignee = DB::table('tickets')
                            ->join('users', 'tickets.assignee_id', 'users.id')
                            ->where('tickets.id', '=', $id)
                            ->select('users.name', 'tickets.assignee_id')
                            ->first();

        //dd($cur_assignee);

        $available_users = DB::table('users')
                                ->join('project_user', 'users.id', 'project_user.user_id')
                                ->join('tickets', 'tickets.project_id', 'project_user.project_id')
                                ->where('tickets.id', '=', $id)
                                ->select('users.name', 'users.id')
                                ->get();

        //dd($available_users);

        return view('ticket.edit', [
            'ticket' => $ticket,
            'projects' => $projects,
            'cur_assignee' => $cur_assignee,
            'available_users' => $available_users,

        ]);
    }

    public function update(Request $request, $id) {

        $ticket = Ticket::findOrFail($id);

        //dd($ticket);

        $cur_assignee = DB::table('tickets')
                            ->join('users', 'tickets.assignee_id', 'users.id')
                            ->where('tickets.id', '=', $id)
                            ->select('users.name', 'tickets.assignee_id')
                            ->first();
        
        //dd($request->input());
        //dd($cur_assignee);

        if($request->has('new_assignee')) {
            $new_assignee = $request->new_assignee;
            $ticket->assignee_id = $new_assignee;
            //$ticket->save();
            // $ticket->
            // Ticket::where('id', $id)
            //     ->update([
            //         'assignee_id' => $request->new_assignee,
            //     ]);
        } else {

        }    

        $ticket->title = $request->ticket_title;
        $ticket->description = $request->ticket_desc;
        $ticket->project_id = $request->ticket_project;
        $ticket->status = $request->ticket_status;
        $ticket->save();
        // Ticket::where('id', $id)
        //         ->update([
        //             'title' => $request->ticket_title,
        //             'description' => $request->ticket_desc,
        //             'project_id' => $request->ticket_project,
        //         ]);


        return redirect('/ticket');
    }

    public function show($id) {
        $ticket = Ticket::findOrFail($id);

        $cur_assignee = DB::table('tickets')
                            ->join('users', 'tickets.assignee_id', 'users.id')
                            ->where('tickets.id', '=', $id)
                            ->select('users.name', 'tickets.assignee_id')
                            ->first();

        //dd($cur_assignee);

        //dd($ticket);
        $projects = DB::table('projects')
                        ->join('tickets', 'tickets.project_id', 'projects.id')
                        ->select('projects.title', 'projects.id')
                        ->get();

        //dd($projects);

        $submitter = DB::table('users')
                        ->join('tickets', 'tickets.submitter_id', 'users.id')
                        ->select('users.name')
                        ->first();

        $comments = DB::table('comments')
                        ->join('users', 'users.id', 'comments.commenter_id')
                        ->select('users.name', 'comments.description', 'comments.created_at')
                        ->where('ticket_id', '=', $id)
                        ->get();
        
        $attachments = DB::table('attachments')
                        ->join('tickets', 'tickets.id', 'attachments.ticket_id')
                        ->join('users', 'users.id', 'attachments.attachment_commenter_id')
                        ->select('attachments.id', 'attachments.ticket_id', 'attachments.description',
                                'attachments.path', 'attachments.attachment_commenter_id',
                                'attachments.created_at', 'users.name')
                        ->where('ticket_id', '=', $id)
                        ->get();
        
        //dd($submitter);
        //dd($attachments);
        //dd($comments);

        //$audits = $ticket->audits;

        $audits = DB::table('audits')
                    ->select('*')
                    ->where('audits.auditable_id', '=', $id)
                    ->get();

        $latest_audit = DB::table('audits')
                    ->select('*')
                    ->where('audits.auditable_id', '=', $id)
                    ->latest('updated_at')
                    ->first();

        // $old_assignee_names = DB::table('users')
        //                         ->join('audits', 'users.id', 'audits.')
        
        //$old_value = json_decode($latest_audit->old_values, true);
        //$new_value = json_decode($latest_audit->new_values, true);


        //$changed_value = array_diff($old_value, $new_value);

        //dd($changed_value);

        // if(array_key_exists('assignee_id', $changed_value)) {
        //     $old_assignee_name = DB::table('users')
        //                         ->select('users.name')
        //                         ->where('users.id', '=', $old_value['assignee_id'])
        //                         ->first();
        // }

        // if(array_key_exists('assignee_id', $changed_value)) {
        //     $new_assignee_name = DB::table('users')
        //                         ->select('users.name')
        //                         ->where('users.id', '=', $new_value['assignee_id'])
        //                         ->first();
        // } else {
        //     $new_assignee_name = "";
        // }

        //dd($audits);
        //dd($latest_audit);
        //dd($old_value);
        //dd($new_value);

        //dd($audits[0]->old_values);

        return view('ticket.show', [
            'ticket' => $ticket,
            'projects' => $projects,
            'cur_assignee' => $cur_assignee,
            'submitter' => $submitter,
            'comments' => $comments,
            'audits' => $audits,
            'latest_audit' => $latest_audit,
            'attachments' => $attachments,
            // 'old_value' => $old_value,
            // 'new_value' => $new_value,
            // 'changed_value' => $changed_value,
            // 'new_assignee_name' => $new_assignee_name,
        ]);
    }

    public function destroy($id) {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('delete', $ticket);
        //dd($ticket);
        $ticket->delete();

        return redirect('/ticket');

    }
}
