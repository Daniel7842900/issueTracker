@extends('layouts.app')

@section('content')
<div class="container create-edit-format">
    <div class="row">
        <div class="col-md-12">
            <h1 class="create-title">Create a New Ticket</h1>
            <form action="/ticket" method="POST">
                @csrf
                <label for="ticket_title">Ticket title:</label>
                <input type="text" id="title" name="title" autocomplete="off">
                @error('title')
                    <span style="color:red;">{{$message}}</span>
                @enderror
                <label for="ticket_desc">Ticket description:</label>
                <input type="text" id="description" name="description" autocomplete="off">
                @error('description')
                    <span style="color:red;">{{$message}}</span>
                @enderror
                <label for="ticket_project">Choose Project:</label>
                <select name="ticket_project" id="ticket_project">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                    @endforeach
                </select>
                <label for="ticket_type">Choose Type:</label>
                <select name="ticket_type" id="ticket_type">
                    <option value="bug">Bug/Error</option>
                    <option value="enhancement">Enhancement</option>
                    <option value="feature">Feature request</option>
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