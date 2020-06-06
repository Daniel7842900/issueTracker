@extends('layouts.app')

@section('content')

<div class="container create-project">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit Ticket</h1>
            <form action="{{ route('ticket.update', ['id' => $ticket->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <label for="ticket_title">Ticket title:</label>
                <input type="text" id="ticket_title" name="ticket_title" value="{{ $ticket->title }}">
                <label for="ticket_desc">Ticket description:</label>
                <input type="text" id="ticket_desc" name="ticket_desc" value="{{ $ticket->description }}">
                <label for="ticket_project">Choose Project:</label>
                <select name="ticket_project" id="ticket_project">
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                    @endforeach
                </select>
                <label for="cur_assignee">Current Assignee:</label>
                @if(is_null($cur_assignee))
                <p>There is no user assigned</p>
                @else
                <p>{{ $cur_assignee }}</p>
                @endif
                <fieldset>
                    <label for="avail_members">Available Members:</label>
                    @if($available_users->isEmpty())
                        <p>No Member is Available</p>
                    @else
                        @foreach($available_users as $available_user)
                        <input type="checkbox" name="avail_members[]" value="{{ $available_user->id }}">{{ $available_user->name }}<br/>
                        @endforeach
                    @endif
                </fieldset>
                <input type="submit" value="Edit project">
            </form>
        </div>
    </div>
</div>

@endsection