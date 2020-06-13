<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ticket;

class Comment extends Model
{
    protected $table = 'comments';

    public function ticket() {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
