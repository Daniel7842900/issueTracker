<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    //

    public function index($id) {
        $ticket = Ticket::findOrFail($id);
        dd($ticket);
        return view('attachment.index', [
            
        ]);
    }
}
