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
                        ->select('tickets.title', 'tickets.description', 'tickets.assignee_id',
                        'tickets.priority', 'tickets.status', 'tickets.created_at', 'tickets.updated_at',
                        'tickets.submitter_id', 'tickets.type', 'tickets.project_id', 'tickets.id')
                        ->get();

        $project_users = DB::table('project_user')
                            ->get();

        $projects = Project::with(['users'])->get();
        
        $submitters = DB::table('users')
                        ->join('tickets', 'tickets.submitter_id', 'users.id')
                        ->select('users.name', 'tickets.submitter_id', 'tickets.id')
                        ->get();

        
        $assignees = DB::table('users')
                        ->join('tickets', 'tickets.assignee_id', 'users.id')
                        ->select('tickets.id', 'users.name')
                        ->get();

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

        return view('ticket.create',[
            'projects' => $projects,
        ]);
    }

    public function store(Request $request) {

        // Validating data request for creating a ticket
        $data = request()->validate([
            'title' => 'required|min:5|max:50',
            'description' => 'required|min:5|max:100'
        ]);

        $ticket = Ticket::create($data);

        $ticket->project_id = request('ticket_project');
        $ticket->type = request('ticket_type');
        $ticket->priority = request('ticket_priority');

        $user_id = Auth::id();

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

        $available_users = DB::table('users')
                                ->join('project_user', 'users.id', 'project_user.user_id')
                                ->join('tickets', 'tickets.project_id', 'project_user.project_id')
                                ->where('tickets.id', '=', $id)
                                ->select('users.name', 'users.id')
                                ->get();

        return view('ticket.edit', [
            'ticket' => $ticket,
            'projects' => $projects,
            'cur_assignee' => $cur_assignee,
            'available_users' => $available_users,

        ]);
    }

    public function update(Request $request, $id) {

        // Validating data request for creating a ticket
        request()->validate([
            'title' => 'required|min:5|max:50',
            'description' => 'required|min:5|max:100'
        ]);

        $ticket = Ticket::findOrFail($id);

        $cur_assignee = DB::table('tickets')
                            ->join('users', 'tickets.assignee_id', 'users.id')
                            ->where('tickets.id', '=', $id)
                            ->select('users.name', 'tickets.assignee_id')
                            ->first();

        if($request->has('new_assignee')) {
            $new_assignee = $request->new_assignee;
            $ticket->assignee_id = $new_assignee;
        } else {

        }    

        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->project_id = $request->ticket_project;
        $ticket->status = $request->ticket_status;
        $ticket->save();

        return redirect('/ticket');
    }

    public function show($id) {
        $ticket = Ticket::findOrFail($id);

        $cur_assignee = DB::table('tickets')
                            ->join('users', 'tickets.assignee_id', 'users.id')
                            ->where('tickets.id', '=', $id)
                            ->select('users.name', 'tickets.assignee_id')
                            ->first();

        $projects = DB::table('projects')
                        ->join('tickets', 'tickets.project_id', 'projects.id')
                        ->select('projects.title', 'projects.id')
                        ->get();

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

        $audits = DB::table('audits')
                    ->select('*')
                    ->where('audits.auditable_id', '=', $id)
                    ->get();

        $latest_audit = DB::table('audits')
                    ->select('*')
                    ->where('audits.auditable_id', '=', $id)
                    ->latest('updated_at')
                    ->first();

        return view('ticket.show', [
            'ticket' => $ticket,
            'projects' => $projects,
            'cur_assignee' => $cur_assignee,
            'submitter' => $submitter,
            'comments' => $comments,
            'audits' => $audits,
            'latest_audit' => $latest_audit,
            'attachments' => $attachments,
        ]);
    }

    public function destroy($id) {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('delete', $ticket);
        $ticket->delete();

        return redirect('/ticket');

    }
}
