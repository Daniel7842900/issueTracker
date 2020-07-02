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
                    <div>
                        <label for="">Your Tickets</label>
                    </div>
                    <hr>
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
                                <td>{{ $project->title }}</td>
                                <td>{{ $submitter->name }}</td>
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
                                <td>
                                    <button><a href="{{ route('ticket.edit', [$ticket->id]) }}">Edit</a></button>
                                </td>
                                <td>
                                    <button><a href="{{ route('ticket.show', [$ticket->id]) }}">Details</a></button>
                                </td>
                                <td>
                                    <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection