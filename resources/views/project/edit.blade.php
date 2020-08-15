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
                <input type="text" id="proj_name" name="proj_name" value="{{ $project->title }}">
                <label for="desc">Project description:</label>
                <input type="text" id="proj_desc" name="proj_desc" value="{{ $project->description }}">
                <label for="manager">Choose Project Manager:</label>
                <select name="manager" id="manager">
                    @foreach($managers as $manager)
                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                    @endforeach
                </select>
                <label for="cur_member">Current Members:</label>
                    @foreach($current_users as $current_user)
                        <input type="checkbox" name="cur_members[]" value="{{ $current_user->id }}">{{ $current_user->name }}<br/>
                    @endforeach
                    <p>* check the box if you want to remove member/members</p>
                <fieldset>
                    <label for="member">Choose Members:</label>
                    @if($available_users->isEmpty())
                        <p>No Member is Available</p>
                    @else
                        @foreach($available_users as $available_user)
                            <input type="checkbox" name="avail_members[]" value="{{ $available_user->id }}">{{ $available_user->name }}<br/>
                        @endforeach
                    @endif
                </fieldset>
                <input type="submit" value="Edit project">
            </form>
        </div>
    </div>
</div>

@endsection