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
                    <div>
                        <span>Title</span>
                        <span>Description</span>
                        <span>Project</span>
                        <span>Submitter</span>
                        <span>Assignee</span>
                        <span>Priority</span>
                        <span>Status</span>
                        <span>Created Date</span>
                        <span>Updated Date</span>
                    </div>
                    <hr>
                    <div>
                        @foreach($tickets as $ticket)
                        <span>{{ $ticket->title }}</span>
                        <span>{{ $ticket->description }}</span>
                        <span>{{ $project->title }}</span>
                        <span>{{ $submitter->name }}</span>
                        @if(is_null($ticket->assignee_id))
                        <span>No member assigned</span>
                        @else
                            @foreach($assignees as $assignee)
                                @if($ticket->id == $assignee->id)
                                <span>{{ $assignee->name }}</span>
                                @else

                                @endif
                            @endforeach
                        @endif
                        <span>{{ $ticket->priority }}</span>
                        <span>{{ $ticket->status }}</span>
                        <span>{{ $ticket->created_at }}</span>
                        <span>{{ $ticket->updated_at }}</span>
                        <span>
                            <button><a href="{{ route('ticket.edit', [$ticket->id]) }}">Edit</a></button>
                            <button><a href="{{ route('ticket.show', [$ticket->id]) }}">Details</a></button>
                            <form action="{{ route('ticket.destroy', [$ticket->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </span>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection