<?php

namespace App\Policies;

use App\Ticket;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function update(User $user, Ticket $ticket)
    {
        // if($user->role_id == 1) {
        //     return true;
        // }

        // if()
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function delete(User $user, Ticket $ticket)
    {
        //dd($ticket);

        $project_user = DB::table('project_user')
                            ->where('project_user.project_id', '=', $ticket->project_id)
                            ->where('project_user.user_id', '=', $user->id )
                            ->first();

        //dd($project_user);

        if($user->role_id == 1) {
            return true;
        } else if($ticket->submitter_id == $user->id) {
            return true;
        }

        if(!isset($project_user)) {
            return false;
        } else {
            if($user->role_id == 2 && $ticket->project_id == $project_user->project_id) {
                return true;
            }
        }

        
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function restore(User $user, Ticket $ticket)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        //
    }
}
