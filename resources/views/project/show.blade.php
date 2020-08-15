@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5>Details for {{ $project->title }}</h5>
</div>
<div class="container wrapper-member-role">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('project.index') }}">Back to project list</a>
            
            
            @if(auth()->user() && auth()->user()->role_id == 1)
                <a href="{{ route('project.edit', $project->id) }}">Edit project</a>
            @elseif(auth()->user()->role_id == 2)
                @foreach($project->users as $user)
                    @if($user->pivot->user_id == auth()->user()->id)
                        <a href="{{ route('project.edit', $project->id) }}">Edit project</a>
                    @endif
                @endforeach
            @else

            @endif

        </div>
    </div>
    <div class="row">
        <div class="card col-md-12">
            <div class="col-md-6">
                <p>Project Name</p>
                <p>{{ $project->title }}</p>
            </div>
            <div class="col-md-6">
                <p>Project Desc</p>
                <p>{{ $project->description }}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-6">
            <div>
                <label for="">Assigned Member</label>
            </div>
            <hr>
            <table>
                <div>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </div>
                <div>
                    @foreach($assigned_members as $assigned_member)
                        <tr>
                            <td>{{ $assigned_member->name }}</td>
                            <td>{{ $assigned_member->email }}</td>
                            <td>{{ $assigned_member->type }}</td>
                        </tr>
                    @endforeach
                </div>
            </table>
        </div>
        <div class="card col-md-6">
            <div>
                <label for="">Tickets for {{ $project->title }}</label>
            </div>
            <hr>
            <table>
                <div>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Submitter</th>
                        <th>Status</th>
                        <th>Created Date</th>
                    </tr>
                </div>
                <div>
                    @foreach($project_tickets as $project_ticket)
                        <tr>
                            <td>{{ $project_ticket->title }}</td>
                            <td>{{ $project_ticket->description }}</td>
                            <td>{{ $project_ticket->name }}</td>
                            <td>{{ $project_ticket->status }}</td>
                            <td>{{ $project_ticket->created_at }}</td>
                        </tr>
                    @endforeach
                </div>
            </table>
        </div>
    </div>
    <!-- <p class="mssg">{{ session('mssg') }}</p> -->
</div>
@endsection