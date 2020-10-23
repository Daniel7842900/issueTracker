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

        $comments = DB::table('comments')
                        ->join('users', 'users.id', 'comments.commenter_id')
                        ->select('commenter_id', 'description', 'created_at')
                        ->where('ticket_id', '=', $id)
                        ->get();

        return view('comment.index', [
            'comments' => $comments,
        ]);
    }

    public function store(Request $request, $id) {

        $comment = new Comment();
        $user_id = Auth::id();
        $ticket = Ticket::findOrFail($id);

        $comment->description = request('comment_message');
        $comment->commenter_id = $user_id;
        $comment->ticket_id = $id;

        $comment->save();

        return redirect()->route('ticket.show', [$ticket])->with('comment has been saved');

    }
}
