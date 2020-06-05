@extends('layouts.app')

@section('content')
<div class="container create-project">
    <div class="row">
        <div class="col-md-12">
            <h1>Create a New Ticket</h1>
            <form action="/project" method="POST">
                @csrf
                <label for="ticket_name">Ticket title:</label>
                <input type="text" id="ticket_name" name="ticket_name">
                <label for="ticket_desc">Ticket description:</label>
                <input type="text" id="ticket_desc" name="ticket_desc">
                <label for="ticket_project">Choose Project:</label>
                @foreach($projects as $project)
                <select name="ticket_project" id="ticket_project">
                    <option value="">{{ $project->title }}</option>
                </select>
                @endforeach
                <label for="ticket_type">Choose Type:</label>
                <select name="ticket_type" id="ticket_type">
                    <option value="bug">Bug/Error</option>
                    <option value="enhancement">Enhancement</option>
                    <option value="reature">Feature request</option>
                </select>
                <label for="ticket_priority">Choose Priority:</label>
                <select name="ticket_priority" id="ticket_priority">
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
                <input type="submit" value="Create a new ticket">
            </form>
        </div>
    </div>
</div>
@endsection