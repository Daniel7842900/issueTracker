<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        $attachment = new Attachment();
        $user_id = Auth::id();
        $ticket = Ticket::findOrFail($id);

        $file = $request->file('attachment_img');

        $filename = 'attachment-'. time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('attachment', $filename);

        $attachment->ticket_id = $id;
        $attachment->description = request('attachment_description');
        $attachment->path = $path;
        $attachment->attachment_commenter_id = $user_id;

        $attachment->save();

        return redirect()->route('ticket.show', [$ticket])->with('attachment has been added');
    }

    public function show($id) {

        $ticket = DB::table('tickets')
                    ->join('attachments', 'tickets.id', 'attachments.ticket_id')
                    ->select('tickets.id', 'tickets.title')
                    ->first();

        $attachment = Attachment::findOrFail($id);

        $uploader = DB::table('users')
                        ->join('attachments', 'users.id', 'attachments.attachment_commenter_id')
                        ->select('users.name', 'attachments.attachment_commenter_id')
                        ->where('attachments.id', '=', $id)
                        ->first();

        $filePath = $attachment->path;

        $content = Storage::disk('public')->get($filePath);

        return view('attachment.show', [
            'attachment' => $attachment,
            'filePath' => $filePath,
            'content' => $content,
            'ticket' => $ticket,
            'uploader' => $uploader,
        ]);
    }

    public function edit($id) {
        $attachment = Attachment::findOrFail($id);
        
        return view('attachment.edit', [
            'attachment' => $attachment,
        ]);
    }

    public function update(Request $request, $id) {

        $attachment = Attachment::findOrFail($id);

        $file = $request->file('attachment_img');

        $user_id = Auth::id();

        if($file != '') {
            $filename = 'attachment-'. time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('attachment', $filename);
        } else {
            $path = $attachment->path;
        }

        $ticket = DB::table('tickets')
                    ->join('attachments', 'tickets.id', 'attachments.ticket_id')
                    ->select('tickets.id')
                    ->first();

        $attachment->ticket_id = $ticket->id;
        $attachment->description = request('attachment_description');
        $attachment->path = $path;
        $attachment->attachment_commenter_id = $user_id;

        $attachment->save();

        return redirect()->route('ticket.show', [$ticket->id])->with('attachment has been edited');
    }

    public function destroy($id) {
        $attachment = Attachment::findOrFail($id);

        $ticket = DB::table('tickets')
                    ->join('attachments', 'tickets.id', 'attachments.ticket_id')
                    ->select('tickets.id')
                    ->first();

        $attachment->delete();

        return redirect()->route('ticket.show', [$ticket->id])->with('attachment has been deleted');
    }
}
