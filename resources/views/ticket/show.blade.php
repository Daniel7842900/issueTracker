@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5>Details for {{ $ticket->title }}</h5>
</div>
<div class="container wrapper-member-role">
    <div class="row">
        <div class="col-md-12 ticket-cursors">
            <div class="ticket-back">
                <a href="{{ route('ticket.index') }}">Back To Ticket List</a>
            </div>
            @if(auth()->user() && auth()->user()->role_id == 1)
            <div class="ticket-edit">
                <a href="{{ route('ticket.edit', $ticket->id) }}">Edit Ticket</a>
            </div>
            @elseif(auth()->user()->id == $ticket->submitter_id)
            <div class="ticket-edit">
                <a href="{{ route('ticket.edit', $ticket->id) }}">Edit Ticket</a>
            </div>
            @else

            @endif
        </div>
    </div>
    <div class="row">
        <div class="card col-md-6">
            <div class="card-header">Ticket Detail</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>Title</p>
                        <p>{{ $ticket->title }}</p>
                    </div>
                    <div class="col-md-6">
                        <p>Description</p>
                        <p>{{ $ticket->description }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p>Assignee</p>
                        @if(is_null($cur_assignee))
                        <p>No Member Assigned</p>
                        @else
                        <p>{{ $cur_assignee->name }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p>Submitter</p>
                        <p>{{ $submitter->name }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p>Project</p>
                        <p>{{ $project->title }}</p>
                    </div>
                    <div class="col-md-6">
                        <p>Priority</p>
                        <p>{{ $ticket->priority }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p>Status</p>
                        <p>{{ $ticket->status }}</p>
                    </div>
                    <div class="col-md-6">
                        <p>Created Date</p>
                        <p>{{ date('m-d-Y', strtotime($ticket->created_at)) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-md-6 comment">
            <div class="card-header">Ticket Comment</div>
            <div class="card-body">
                @include('comment.index', ['id' => $ticket->id])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-6">
            <div class="card-header">Ticket History</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <span>Changed Value</span><br>
                        <span>Changed Date</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    @foreach($audits as $audit)
                    <div class="col-md-12">
                        @php
                            $old_value = json_decode($audit->old_values, true);
                            $new_value = json_decode($audit->new_values, true);
                            $changed_value = array_diff($old_value, $new_value);
                            
                        @endphp
                        @if(array_key_exists('title', $changed_value))
                            <label for="">Title:</label>
                            <span>{{ $old_value['title'] }} -> {{ $new_value['title'] }}</span>
                            <br>
                        @endif
                        @if(array_key_exists('description', $changed_value))
                            <label for="">Description:</label>
                            <span>{{ $old_value['description'] }} -> {{ $new_value['description'] }}</span>
                            <br>
                        @endif
                        <label for="">Changed Date:</label>
                        <span>{{ $new_value['updated_at'] }}</span>
                        <hr>
                    </div>
                    @endforeach
                    
                </div>
            </div>            
        </div>
        <div class="card col-md-6">
            <div class="card-header">Ticket Attachment</div>
            <div class="card-body">
                @include('attachment.index', ['id' => $ticket->id])
            </div>
        </div>
    </div>
    <!-- <p class="mssg">{{ session('mssg') }}</p> -->
</div>
@endsection