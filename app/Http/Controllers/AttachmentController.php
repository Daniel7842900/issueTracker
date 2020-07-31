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

        $ticket = DB::table('tickets')
                    ->join('attachments', 'tickets.id', 'attachments.ticket_id')
                    ->select('tickets.id', 'tickets.title')
                    ->first();

        //dd($ticket);
                    
        $attachment = Attachment::findOrFail($id);

        $uploader = DB::table('users')
                        ->join('attachments', 'users.id', 'attachments.attachment_commenter_id')
                        ->select('users.name', 'attachments.attachment_commenter_id')
                        ->where('attachments.id', '=', $id)
                        ->first();

        //dd($uploader);

        $filePath = $attachment->path;
        //dd($filePath);
        //$fullPath = public_path()."/".$filePath;
        $content = Storage::disk('public')->get($filePath);
        //dd($content);

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
        
        //dd($attachment->attachment_description);

        return view('attachment.edit', [
            'attachment' => $attachment,
        ]);
    }

    public function update(Request $request, $id) {

        $attachment = Attachment::findOrFail($id);

        //dd($request->input());

        $file = $request->file('attachment_img');

        $user_id = Auth::id();

        //dd($file);

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

        //dd($ticket);

        // if($request->attachment_description == '') {
        //     $attachment->description
        // }

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
        //dd($attachment);

        //dd($ticket);
        $attachment->delete();

        return redirect()->route('ticket.show', [$ticket->id])->with('attachment has been deleted');
    }
}
