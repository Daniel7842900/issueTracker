@extends('layouts.app')

@section('content')
    <div id="header-manage-member" class="col-md-4">
        <h5>Projects</h5>
    </div>
    <div class="container wrapper-member-role">
        <div class="row">
            <div class="col-md-12">
                <button><a href="{{ route('project.create') }}">Create New Project</a></button>
                <div class="card">
                    <div>
                        <label for="">Your Projects</label>
                    </div>
                    <hr>
                    <div>
                        <span>Name</span>
                        <span>Description</span>
                        <span>Members</span>
                        <span>Created Date</span>
                    </div>
                    <hr>
                    @foreach($projects as $project)
                    <div>
                        <span>{{ $project->name }}</span>
                        <span>{{ $project->desc }}</span>
                        <span>
                            
                            <select name="proj_member" id="proj_member">
                                <option value=""></option>
                            </select>
                        </span>
                        <span>Created Date</span>
                    </div>
                    @endforeach
                </div>
                <!-- <p class="mssg">{{ session('mssg') }}</p> -->
            </div>
        </div>
    </div>






@endsection