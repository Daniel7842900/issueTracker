<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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

        dd($request->input());
        $ticket->name = request('ticket_name');
    }
}
