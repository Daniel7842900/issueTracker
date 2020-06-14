<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Ticket extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    protected $table = 'tickets';

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function project() {
        return $this->belongsTo('App\Project');
    }

    // protected $auditInclude  = [

    //     'title', 'description'

    // ];
    
}
