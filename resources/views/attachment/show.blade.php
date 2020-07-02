@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5>Attachment .name. for .ticket name .</h5>
</div>
<div class="container wrapper-member-role">
    <div class="row">
        <div class="col-md-12">
            <a href="">Back to ticket list</a>
            <a href="">Edit ticket</a>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <img src="{{asset(` `)}}" alt="">
            <p>description: </p>
            <p>Uploaded: </p>
            <p>Created Date: </p>
            <p>Updated Date: </p>
        </div>
    </div>
</div>

@endsection