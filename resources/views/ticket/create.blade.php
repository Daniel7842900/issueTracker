@extends('layouts.app')

@section('content')
<div class="container create-project">
    <div class="row">
        <div class="col-md-12">
            <h1>Create a New Ticket</h1>
            <form action="/project" method="POST">
                @csrf
                <label for="name">Ticket title:</label>
                <input type="text" id="ticket_name" name="ticket_name">
                <label for="desc">Ticket description:</label>
                <input type="text" id="ticket_desc" name="ticket_desc">
                <label for="project">Choose Project:</label>
                <select name="manager" id="manager">
                    <option value=""></option>
                </select>
                <label for="project">Choose Type:</label>
                <select name="manager" id="manager">
                    <option value=""></option>
                </select><label for="project">Choose Member:</label>
                <select name="manager" id="manager">
                    <option value=""></option>
                </select>
                <label for="project">Choose Priority:</label>
                <select name="manager" id="manager">
                    <option value=""></option>
                </select>
                <input type="submit" value="Create a new project">
            </form>
        </div>
    </div>
</div>
@endsection