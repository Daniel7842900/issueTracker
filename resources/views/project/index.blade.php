@extends('layouts.app')

@section('content')
    <div id="header-manage-member" class="col-md-4">
        <h5>Projects</h5>
    </div>
    <div class="container wrapper-member-role">
        <div class="row">
            <div class="col-md-12">
                @if(auth()->user() && auth()->user()->role_id == 1)
                    <button><a href="{{ route('project.create') }}">Create New Project</a></button>
                @endif
                <div class="card">
                    <div class="card-header">Your Projects</div>
                    <div class="card-body">
                        <table>
                            <div>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Members</th>
                                    <th>Created Date</th>
                                </tr>
                            </div>
                            <div>
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
                                        <td>{{ $project->created_at }}</td>
                                            @if(auth()->user() && auth()->user()->role_id == 1)
                                                <td>
                                                    <button><a href="{{ route('project.edit', $project->id) }}">Edit</a></button>
                                                </td>
                                            @elseif(auth()->user()->role_id == 2)
                                                @foreach($project->users as $user)
                                                    @if($user->pivot->user_id == auth()->user()->id)
                                                        <td>
                                                            <button><a href="{{ route('project.edit', $project->id) }}">Edit</a></button>
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @else

                                            @endif
                                            <td>
                                                <button><a href="{{ route('project.show', $project->id) }}">Details</a></button>
                                            </td>
                                        @if(auth()->user() && auth()->user()->role_id == 1)
                                            <td>
                                                <form action="{{ route('project.destroy', $project->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </div>
                        </table>
                    </div>
                </div>
                <!-- <p class="mssg">{{ session('mssg') }}</p> -->
            </div>
        </div>
    </div>
@endsection