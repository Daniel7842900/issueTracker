<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Ticket;

class Project extends Model
{
    
    use SoftDeletes;

    protected $table = 'projects';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'description'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

}
