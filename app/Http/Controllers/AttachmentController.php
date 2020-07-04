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
                        ->select('users.name')
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
}
