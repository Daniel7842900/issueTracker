<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //

    protected $table = 'tickets';

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function project() {
        return $this->belongsTo('App\Project');
    }

    
}
