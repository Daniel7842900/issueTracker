@extends('layouts.app')

@section('content')

<div id="header-manage-member" class="col-md-4">
    <h5 class="detail-title">Details for {{ $ticket->title }}</h5>
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
    <div class="row ticket-detail-comment-row">
        <div class="card col-md-6 px-md-2 py-md-2 ticket-info-card ticket-detail-card">
            <div class="card-header">Ticket Detail</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Title</h3>
                        <p>{{ $ticket->title }}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Description</h3>
                        <p>{{ $ticket->description }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Assignee</h3>
                        @if(is_null($cur_assignee))
                            <p>No Member Assigned</p>
                        @else
                            <p>{{ $cur_assignee->name }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h3>Submitter</h3>
                        <p>{{ $submitter->name }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Project</h3>
                        @foreach($projects as $project)
                            @if($project->id == $ticket->project_id)
                                <p>{{ $project->title }}</p>
                                @break
                            @else

                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <h3>Priority</h3>
                        <p>{{ $ticket->priority }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Status</h3>
                        <p>{{ $ticket->status }}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Created Date</h3>
                        <p>{{ date('m-d-Y', strtotime($ticket->created_at)) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-md-6 px-md-2 py-md-2 comment ticket-comment-card ticket-detail-card">
            <div class="card-header">Ticket Comment</div>
            <div class="card-body">
                @include('comment.index', ['id' => $ticket->id])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-md-6 px-md-2 py-md-2 ticket-history-card ticket-detail-card">
            <div class="card-header">Ticket History</div>
            <div class="card-body">
                <div class="row">
                    <table id="ticket-history-table" class="table-striped table-bordered compact">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                                <th>Changed Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($audits as $audit)
                            <tr>
                                @php
                                    $old_value = json_decode($audit->old_values, true);
                                    $new_value = json_decode($audit->new_values, true);
                                    $changed_value = array_diff($old_value, $new_value);
                                @endphp
                                @if(!empty($old_value))
                                    <td>
                                        @if(array_key_exists('title', $changed_value))
                                            Title:
                                            <br>
                                        @endif
                                        @if(array_key_exists('description', $changed_value))
                                            Description:
                                            <br>
                                        @endif
                                        @if(array_key_exists('project_id', $changed_value))
                                            Project_id:
                                            <br>
                                        @endif
                                    </td>
                                    <td>
                                        @if(array_key_exists('title', $changed_value))
                                            {{ $old_value['title'] }}
                                            <br>
                                        @endif
                                        @if(array_key_exists('description', $changed_value))
                                            {{ $old_value['description'] }}
                                            <br>
                                        @endif
                                        @if(array_key_exists('project_id', $changed_value))
                                            {{\App\Project::where(['id' => $old_value['project_id']])->pluck('title')->first()}}
                                            <br>
                                        @endif
                                    </td>
                                    <td>
                                        @if(array_key_exists('title', $changed_value))
                                            {{ $new_value['title'] }}
                                            <br>
                                        @endif
                                        @if(array_key_exists('description', $changed_value))
                                            {{ $new_value['description'] }}
                                            <br>
                                        @endif
                                        @if(array_key_exists('project_id', $changed_value))
                                            {{ $project->title }}
                                            <br>
                                        @endif
                                    </td>
                                    <td>
                                        @if(array_key_exists('updated_at', $new_value))
                                            {{ $new_value['updated_at'] }}
                                        @else

                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
        <div class="card col-md-6 px-md-2 py-md-2 ticket-attachment-card ticket-detail-card">
            <div class="card-header">Ticket Attachment</div>
            <div class="card-body">
                @include('attachment.index', ['id' => $ticket->id])
            </div>
        </div>
    </div>
    <!-- <p class="mssg">{{ session('mssg') }}</p> -->
</div>
<script>

    $('#ticket-history-table').DataTable({
        "lengthMenu": [[3], [3]],
        "columns": [
            {"width": "25%"},
            {"width": "25%"},
            {"width": "25%"},
            {"width": "25%"}
        ]
    });

</script>
@endsection