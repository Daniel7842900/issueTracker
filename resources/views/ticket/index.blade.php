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
                        <table id="ticket-table" class="table-striped table-bordered compact" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Project</th>
                                    <th>Submitter</th>
                                    <th>Assignee</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
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
                                        <td class="function-buttons">
                                            @if(auth()->user() && auth()->user()->role_id == 1)
                                                <button><a href="{{ route('ticket.edit', [$ticket->id]) }}">Edit</a></button>
                                            @elseif(auth()->user()->id == $ticket->submitter_id)
                                                <button><a href="{{ route('ticket.edit', [$ticket->id]) }}">Edit</a></button>
                                            @else
                                                <button disabled>Edit</button>
                                            @endif
                                                <button><a href="{{ route('ticket.show', [$ticket->id]) }}">Details</a></button>
                                            @if(auth()->user() && auth()->user()->role_id == 1)
                                                <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @elseif(auth()->user()->id == $ticket->submitter_id)
                                                <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @else
                                                @foreach($project_users as $project_user)
                                                    @if(auth()->user()->role_id == 2 && $ticket->project_id == $project_user->project_id &&
                                                    auth()->user()->id == $project_user->user_id)
                                                        <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                        @break
                                                    @else
                                                        <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button disabled>Delete</button>
                                                        </form>
                                                        @break
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $('#ticket-table').DataTable({
        "lengthMenu": [[5], [5]],
        "columns": [
            {"width": "10%"},
            {"width": "10%"},
            {"width": "10%"},
            {"width": "10%"},
            {"width": "10%"},
            {"width": "10%"},
            {"width": "10%"},
            {"width": "10%"},
            {"width": "10%"},
            {"width": "10%"},
        ]
    });
</script>
@endsection