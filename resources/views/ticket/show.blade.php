@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5>Details for {{ $ticket->title }}</h5>
</div>
<div class="container wrapper-member-role">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('ticket.index') }}">Back to ticket list</a>
            <a href="{{ route('ticket.edit', $ticket->id) }}">Edit ticket</a>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-6">
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
                    <p>{{ $cur_assignee->name }}</p>
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
                    <p>{{ $ticket->created_at }}</p>
                </div>
            </div>
        </div>
        <div class="card col-md-6 comment">
            @include('comment.index', ['id' => $ticket->id])
        </div>
    </div>
    <div class="row">
        <div class="card col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Ticket History</label>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <span>Title</span>
                    <span>Old Value</span>
                    <span>New Value</span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <span>Title</span>
                    <span>Old Value</span>
                    <span>New Value</span>
                    <span>Date changed</span>
                </div>
            </div>
        </div>
        <div class="card col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <p>Add an Attachment</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <p>Select an attachment</p>
                        <button></button>
                    </div>
                    <div>
                        <p>Leave a description</p>
                        <input type="text">
                        <input type="submit">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="">Ticket Attachments</label>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <span>File</span>
                    <span>Uploader</span>
                    <span>Notes</span>
                    <span>Uploaded Date</span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <span>File</span>
                    <span>Uploader</span>
                    <span>Notes</span>
                    <span>Uploaded Date</span>
                </div>
            </div>
        </div>
    </div>
    <!-- <p class="mssg">{{ session('mssg') }}</p> -->
</div>
@endsection