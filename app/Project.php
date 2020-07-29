<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Ticket;

class Project extends Model
{
    //
    protected $table = 'projects';

    public function users() {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

}
