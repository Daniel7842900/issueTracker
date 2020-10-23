@extends('layouts.app')

@section('content')
    <div id="header-manage-member" class="col-md-4">
        <h5 class="section_title">Projects</h5>
    </div>
    <div class="container wrapper-member-role">
        <div class="row">
            <div class="col-md-12">
                @can('create', App\Project::class)
                    <a href="{{ route('project.create') }}">
                        <button type="button" class="btn btn-primary create_button">Create New Project</button>
                    </a>
                @endcan
                <div class="card project_card">
                    <div class="card-header">Your Projects</div>
                    <div class="card-body">
                        <table id="project-table" class="table table-striped table-bordered compact" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Members</th>
                                    <th>Created Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{ $project->title }}</td>
                                        <td>{{ $project->description }}</td>
                                        <td>
                                            <select name="proj_member" id="proj_member">
                                                @foreach($project->users as $user)
                                                    <option value="">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ date('m-d-Y', strtotime($project->created_at)) }}</td>
                                        <td class="function-buttons">
                                            <a href="{{ route('project.edit', $project->id) }}"><button class="btn btn-warning edit_btn">Edit</button></a>
                                            <a href="{{ route('project.show', $project->id) }}"><button class="btn detail_btn">Details</button></a>
                                            @can('delete', $project)
                                            <form action="{{ route('project.destroy', $project->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Are you sure?')" class="btn delete_btn">Delete</button>
                                            </form>
                                            @endcan
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <p class="mssg">{{ session('mssg') }}</p> -->
            </div>
        </div>
    </div>

<script>

    $('#project-table').DataTable({
        "lengthMenu": [[5], [5]],
        "columns": [
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
        ]
    });

</script>
@endsection