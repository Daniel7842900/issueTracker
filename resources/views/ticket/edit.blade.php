@extends('layouts.app')

@section('content')

<div class="container create-edit-format">
    <div class="row">
        <div class="col-md-12">
            <h1 class="edit-title">Edit Ticket</h1>
            <form action="{{ route('ticket.update', ['id' => $ticket->id]) }}" method="POST" id="edit-ticket-form">
                @csrf
                @method('PATCH')
                <label for="ticket_title">Ticket title:</label>
                <input type="text" id="title" name="title" value="{{ $ticket->title }}" autocomplete="off" required data-parsley-pattern="[a-zA-Z0-9`~!@#$%^&*()-_+'={} ]+" minlength="5" maxlength="50" data-parsley-trigger="keyup">
                @error('title')
                    <span style="color:red;">{{$message}}</span>
                @enderror
                <label for="ticket_desc">Ticket description:</label>
                <input type="text" id="description" name="description" value="{{ $ticket->description }}" autocomplete="off" required data-parsley-pattern="[a-zA-Z0-9`~!@#$%^&*()-_+'={} ]+" minlength="5" maxlength="100" data-parsley-trigger="keyup">
                @error('description')
                    <span style="color:red;">{{$message}}</span>
                @enderror
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
                    <p>{{ $cur_assignee->name }}</p>
                @endif
                <fieldset>
                    <label for="avail_members">Available Members:</label>
                    @if($available_users->isEmpty())
                        <p>No Member is Available</p>
                    @else
                        @foreach($available_users as $available_user)
                            @if(is_null($cur_assignee))
                                <input type="checkbox" name="new_assignee" value="{{ $available_user->id }}">{{ $available_user->name }}<br/>
                            @else
                                @if($available_user->name == $cur_assignee->name)

                                @else
                                <input type="checkbox" name="new_assignee" value="{{ $available_user->id }}">{{ $available_user->name }}<br/>
                                @endif
                            @endif
                        @endforeach
                        <p>* Only one member can be assigned</p>
                    @endif
                </fieldset>
                <label for="ticket_status">Ticket status:</label>
                <select name="ticket_status" id="ticket_status">
                    <option value="open">open</option>
                    <option value="closed">closed</option>
                </select>
                <input type="submit" value="Edit project">
            </form>
        </div>
    </div>
</div>
<script>

    $('#edit-ticket-form').parsley();

</script>
@endsection