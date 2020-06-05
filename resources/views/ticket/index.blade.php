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
                        <span></span>
                        <span></span>
                        <span>
                            <select name="proj_member" id="proj_member">
                                <option value=""></option>
                            </select>
                        </span>
                        <span></span>
                        <span>
                            <button><a href="">Edit</a></button>
                            <button><a href="">Details</a></button>
                            <form action="" method="POST">
                                
                                <button onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection