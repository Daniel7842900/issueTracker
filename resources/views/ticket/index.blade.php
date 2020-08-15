@extends('layouts.app')

@section('content')
    <div id="header-manage-member" class="col-md-4">
        <h5>Tickets</h5>
    </div>
    <div class="container wrapper-member-role">
        <div class="row">
            <div class="col-md-12">
                <button><a href="{{ route('ticket.create') }}">Create New Ticket</a></button>
                <div class="card">
                    <div class="card-header">Your Tickets</div>
                    <div class="card-body">
                        <table>
                            <div>
                                <tr style="border-bottom:1px solid black">
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Project</th>
                                    <th>Submitter</th>
                                    <th>Assignee</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                </tr>
                            </div>
                            <div>
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->description }}</td>
                                    @foreach($projects as $project)
                                        @if($project->id == $ticket->project_id)
                                        <td>{{ $project->title }}</td>
                                        @else
                                        
                                        @endif
                                    @endforeach
                                    @foreach($submitters as $submitter)
                                        @if($submitter->id == $ticket->id)
                                        <td>{{ $submitter->name }}</td>
                                        @else

                                        @endif
                                    @endforeach
                                    @if(is_null($ticket->assignee_id))
                                    <td>No member assigned</td>
                                    @else
                                        @foreach($assignees as $assignee)
                                            @if($ticket->id == $assignee->id)
                                            <td>{{ $assignee->name }}</td>
                                            @else

                                            @endif
                                        @endforeach
                                    @endif
                                    <td>{{ $ticket->priority }}</td>
                                    <td>{{ $ticket->status }}</td>
                                    <td>{{ date('n-j-Y', strtotime($ticket->created_at)) }}</td>
                                    <td>{{ date('n-j-Y', strtotime($ticket->updated_at)) }}</td>
                                    @if(auth()->user() && auth()->user()->role_id == 1)
                                    <td>
                                        <button><a href="{{ route('ticket.edit', [$ticket->id]) }}">Edit</a></button>
                                    </td>
                                    @elseif(auth()->user()->id == $ticket->submitter_id)
                                    <td>
                                        <button><a href="{{ route('ticket.edit', [$ticket->id]) }}">Edit</a></button>
                                    </td>
                                    @else

                                    @endif
                                    <td>
                                        <button><a href="{{ route('ticket.show', [$ticket->id]) }}">Details</a></button>
                                    </td>
                                    
                                    @if(auth()->user() && auth()->user()->role_id == 1)
                                    <td>
                                        <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                    @elseif(auth()->user()->id == $ticket->submitter_id)
                                    <td>
                                        <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                    @else
                                        @foreach($project_users as $project_user)
                                            @if(auth()->user()->role_id == 2 && $ticket->project_id == $project_user->project_id &&
                                             auth()->user()->id == $project_user->user_id)
                                            <td>
                                                <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                                @break
                                            @else

                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                                @endforeach
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection