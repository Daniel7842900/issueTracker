@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5>Details for {{ $project->title }}</h5>
</div>
<div class="container wrapper-member-role">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('project.index') }}">Back to project list</a>
            <a href="{{ route('project.edit', $project->id) }}">Edit project</a>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-12">
            <div class="col-md-6">
                <p>Project Name</p>
                <p>{{ $project->title }}</p>
            </div>
            <div class="col-md-6">
                <p>Project Desc</p>
                <p>{{ $project->description }}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div>
                <label for="">Assigned Member</label>
            </div>
            <hr>
            <div>
                <span>Name</span>
                <span>Email</span>
                <span>Role</span>
            </div>
            <hr>
            @foreach($assigned_members as $assigned_member)
            <div>
                <span>{{ $assigned_member->name }}</span>
                <span>{{ $assigned_member->email }}</span>
                <span>{{ $assigned_member->type }}</span>
            </div>
            @endforeach
        </div>
        <div class="card">
            <div>
                <label for="">Tickets for {{ $project->title }}</label>
            </div>
            <hr>
            <div>
                <span>Title</span>
                <span>Submitter</span>
                <span>Status</span>
                <span>Created Date</span>
                <span>Details</span>
            </div>
            <hr>
            <div>
                <span>Title</span>
                <span>Submitter</span>
                <span>Status</span>
                <span>Created Date</span>
                <span>Details</span>
            </div>
        </div>
    </div>
    <!-- <p class="mssg">{{ session('mssg') }}</p> -->
</div>
@endsection