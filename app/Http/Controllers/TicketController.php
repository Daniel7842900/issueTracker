<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Ticket;


class TicketController extends Controller
{
    public function index() {

        return view('ticket.index');
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
}
