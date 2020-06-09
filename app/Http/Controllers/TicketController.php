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

        $assignees = DB::table('users')
                        ->join('tickets', 'tickets.assignee_id', 'users.id')
                        ->select('tickets.id', 'users.name')
                        ->get();

        //dd($submitter);
        //dd($assignees);

        return view('ticket.index', [
            'tickets' => $tickets,
            'project' => $project,
            'submitter' => $submitter,
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

        $cur_assignee = DB::table('tickets')
                            ->join('users', 'tickets.assignee_id', 'users.id')
                            ->where('tickets.id', '=', $id)
                            ->select('users.name', 'tickets.assignee_id')
                            ->first();
        
        //dd($request->input());
                            //dd($cur_assignee);

        if($request->has('new_assignee')) {
            Ticket::where('id', $id)
                ->update([
                    'assignee_id' => $request->new_assignee,
                ]);
        } else {

        }    

        Ticket::where('id', $id)
                ->update([
                    'title' => $request->ticket_title,
                    'description' => $request->ticket_desc,
                    'project_id' => $request->ticket_project,
                ]);


        return redirect('/ticket');
    }

    public function show($id) {
        $ticket = Ticket::findOrFail($id);

        $cur_assignee = DB::table('tickets')
                            ->join('users', 'tickets.assignee_id', 'users.id')
                            ->where('tickets.id', '=', $id)
                            ->select('users.name', 'tickets.assignee_id')
                            ->first();

        $project = DB::table('projects')
                        ->join('tickets', 'tickets.project_id', 'projects.id')
                        ->select('projects.title')
                        ->first();

        $submitter = DB::table('users')
                        ->join('tickets', 'tickets.submitter_id', 'users.id')
                        ->select('users.name')
                        ->first();

        return view('ticket.show', [
            'ticket' => $ticket,
            'project' => $project,
            'cur_assignee' => $cur_assignee,
            'submitter' => $submitter,
        ]);
    }

    public function destroy($id) {
        $ticket = Ticket::findOrFail($id);
        //dd($ticket);
        $ticket->delete();

        return redirect('/ticket');

    }
}
