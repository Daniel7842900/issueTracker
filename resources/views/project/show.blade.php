@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5>Details for {{ $project->title }}</h5>
</div>
<div class="container wrapper-member-role">
    <div class="row">
        <div class="col-md-12 project-cursors">
            <div class="project-back">
                <a href="{{ route('project.index') }}">Back to project list</a>
            </div>
            <div class="project-edit">
                @can('update', $project)
                    <a href="{{ route('project.edit', $project->id) }}">Edit project</a>
                @endcan
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="card col-md-12">
            <div class="card-header">
                Details
            </div>
            <div class="card-body">
                <div class="col-md-6">
                    <h3>Project Name</h3>
                    <p>{{ $project->title }}</p>
                </div>
                <div class="col-md-6">
                    <h3>Project Description</h3>
                    <p>{{ $project->description }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-6 project-member-card">
            <div class="card-header">
                Assigned Member
            </div>
            <div class="card-body">
                <table id="project-member-table" class="display table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assigned_members as $assigned_member)
                            <tr>
                                <td>{{ $assigned_member->name }}</td>
                                <td>{{ $assigned_member->email }}</td>
                                <td>{{ $assigned_member->type }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-md-6 project-ticket-card">
            <div class="card-header">
                Tickets for {{ $project->title }}
            </div>
            <div class="card-body">
                <table id="project-ticket-table" class="display table-striped table-bordered compact" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Submitter</th>
                            <th>Status</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($project_tickets as $project_ticket)
                            <tr>
                            
                                <td>{{ $project_ticket->title }}</td>
                                <td>{{ $project_ticket->description }}</td>
                                <td>{{ $project_ticket->name }}</td>
                                <td>{{ $project_ticket->status }}</td>
                                <td>{{ date('m-d-Y', strtotime($project_ticket->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- <p class="mssg">{{ session('mssg') }}</p> -->
</div>

<script>

    $('table.display').DataTable({
        "lengthMenu": [[5], [5]]
    });

</script>
@endsection