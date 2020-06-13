<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Ticket;

class CommentController extends Controller
{
    public function index($id) {
        $ticket = Ticket::findOrFail($id);
        echo $ticket;
        //dd($ticket);
        return view('ticket.show', [
            'ticket' => $ticket,
        ]);
    }

    public function store(Request $request, $id) {
        //dd($request->input());
        //dd($id);
        $comment = new Comment();
        $user_id = Auth::id();
        $ticket = Ticket::findOrFail($id);
        //$ticket_id = $ticket->id;
        //dd($ticket_id);


        //dd($user_id);
        //dd($ticket);

        $comment->description = request('comment_message');
        $comment->commenter_id = $user_id;
        $comment->ticket_id = $id;

        $comment->save();

        return redirect()->route('ticket.show', [$ticket])->with('comment has been saved');

    }
}
