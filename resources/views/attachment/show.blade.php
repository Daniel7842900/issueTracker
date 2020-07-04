@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5>Attachment for </h5>
</div>
<div class="container wrapper-member-role">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('ticket.show', $ticket->id) }}">Back to ticket list</a>
            <a href="">Edit attachment</a>
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