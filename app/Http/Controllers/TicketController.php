<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Ticket;


class TicketController extends Controller
{
    public function index() {
        $tickets = DB::table('tickets')
                        ->get();

        //dd($tickets);

        $project = DB::table('projects')
                        ->join('tickets', 'tickets.project_id', 'projects.id')
                        ->select('projects.title')
                        ->first();

        $submitter = DB::table('users')
                        ->join('tickets', 'tickets.submitter_id', 'users.id')
                        ->select('users.name')
                        ->first();

        //dd($submitter);

        return view('ticket.index', [
            'tickets' => $tickets,
            'project' => $project,
            'submitter' => $submitter,
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
                            ->select('users.name', 'tickets.assignee_id')
                            ->first();

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
        $tickets = DB::table('tickets')
                        ->get();

        
    }
}
