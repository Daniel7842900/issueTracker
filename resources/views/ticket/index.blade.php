@extends('layouts.app')

@section('content')
    <div id="header-manage-member" class="col-md-4">
        <h5 class="section_title">Tickets</h5>
    </div>
    <div class="container wrapper-member-role">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('ticket.create') }}">
                    <button class="btn btn-primary create_button">Create New Ticket</button>
                </a>
                <div class="card ticket-card">
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
                                                <a href="{{ route('ticket.edit', [$ticket->id]) }}"><button class="btn btn-warning edit_btn">Edit</button></a>
                                            @elseif(auth()->user()->id == $ticket->submitter_id)
                                                <a href="{{ route('ticket.edit', [$ticket->id]) }}"><button class="btn btn-warning edit_btn">Edit</button></a>
                                            @else
                                                <button class="btn btn-warning edit_btn" disabled>Edit</button>
                                            @endif
                                                <a href="{{ route('ticket.show', [$ticket->id]) }}"><button class="btn detail_btn">Details</button></a>
                                            @if(auth()->user() && auth()->user()->role_id == 1)
                                                <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')" class="btn delete_btn">Delete</button>
                                                </form>
                                            @elseif(auth()->user()->id == $ticket->submitter_id)
                                                <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')" class="btn delete_btn">Delete</button>
                                                </form>
                                            @else
                                                @foreach($project_users as $project_user)
                                                    @if(auth()->user()->role_id == 2 && $ticket->project_id == $project_user->project_id &&
                                                    auth()->user()->id == $project_user->user_id)
                                                        <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('Are you sure?')" class="btn delete_btn">Delete</button>
                                                        </form>
                                                        @break
                                                    @else
                                                        <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn delete_btn" disabled>Delete</button>
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