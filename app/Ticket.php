<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Ticket extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    protected $table = 'tickets';

    protected $fillable = [
        'title',
        'description'
    ];

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function attachments() {
        return $this->hasMany('App\Attachment');
    }

    // protected $auditInclude  = [

    //     'title', 'description'

    // ];
    
}
