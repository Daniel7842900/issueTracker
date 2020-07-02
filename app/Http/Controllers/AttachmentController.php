<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Attachment;
use App\Ticket;

class AttachmentController extends Controller
{
    //

    public function index($id) {
        $ticket = Ticket::findOrFail($id);
        dd($ticket);
        return view('attachment.index', [
            
        ]);
    }

    public function store(Request $request, $id) {
        //dd($request->input());

        $attachment = new Attachment();
        $user_id = Auth::id();
        $ticket = Ticket::findOrFail($id);

        $file = $request->file('attachment_img');

        //dd($file);
        $filename = 'attachment-'. time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('attachment', $filename);

        $attachment->ticket_id = $id;
        $attachment->description = request('attachment_description');
        $attachment->path = $path;
        $attachment->attachment_commenter_id = $user_id;
        //dd($path);

        $attachment->save();

        return redirect()->route('ticket.show', [$ticket])->with('attachment has been added');
    }

    public function show($id) {

        $attachment = Attachment::findOrFail($id);


        return view('attachment.show');
    }
}
