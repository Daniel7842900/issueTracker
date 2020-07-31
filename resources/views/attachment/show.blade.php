@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5>Attachment for </h5>
</div>
<div class="container wrapper-member-role">
    <div class="row">
        <div class="col-md-12 attachment-cursors">
            <div class="attachment-back">
                <a href="{{ route('ticket.show', $ticket->id) }}">Back to ticket list</a>
            </div>
            @if(auth()->user() && auth()->user()->role_id == 1)
            <div class="attachment-edit">
                <a href="{{ route('attachment.edit', $attachment->id) }}">Edit attachment</a>
            </div>
            @elseif(auth()->user()->id == $uploader->attachment_commenter_id)
            <div class="attachment-edit">
                <a href="{{ route('attachment.edit', $attachment->id) }}">Edit attachment</a>
            </div>
            @else

            @endif
        </div>
    </div>
    <div class="row">
        <div class="card">
            <img src="{{url('storage/'.$filePath)}}" alt="" width="800px" height="200px">
            
            <p>Description: {{ $attachment->description }}</p>
            <p>Uploader: {{ $uploader->name }}</p>
            <p>Created Date: {{ $attachment->created_at }}</p>
            <p>Updated Date: {{ $attachment->updated_at }}</p>
        </div>
    </div>
</div>

@endsection