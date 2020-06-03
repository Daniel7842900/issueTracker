@extends('layouts.app')

@section('content')

<div class="container create-project">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit Project</h1>
            <form action="{{ route('project.update', ['id' => $project->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <label for="name">Project name:</label>
                <input type="text" id="proj_name" name="proj_name" value="{{ $project->name }}">
                <label for="desc">Project description:</label>
                <input type="text" id="proj_desc" name="proj_desc" value="{{ $project->desc }}">
                <label for="manager">Choose Project Manager:</label>
                <select name="manager" id="manager">
                    @foreach($managers as $manager)
                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                    @endforeach
                </select>
                <label for="cur_member">Current Members:</label>
                    @foreach($current_users as $current_user)
                    <ul>
                        <li>{{ $current_user->name }}</li>
                        <span><a href="">delete member</a></span>
                    </ul>
                    @endforeach
                <fieldset>
                    <label for="member">Choose Members:</label>
                    @if($available_users->isEmpty())
                        <p>No Member is Available</p>
                    @else
                        @foreach($available_users as $available_user)
                        <input type="checkbox" name="members[]" value="{{ $available_user->id }}">{{ $available_user->name }}<br/>
                        @endforeach
                    @endif
                </fieldset>
                <input type="submit" value="Edit project">
            </form>
        </div>
    </div>
</div>

@endsection