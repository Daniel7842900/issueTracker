@extends('layouts.app')

@section('content')
<div class="container create-edit-format">
    <div class="row">
        <div class="col-md-12">
            <h1 class="create-title">Create a New Project</h1>
            <form action="/project" method="POST">
                @csrf
                <label for="name">Project title:</label>
                <input type="text" id="title" name="title" autocomplete="off">
                @error('title')
                    <span style="color:red;">{{$message}}</span>
                @enderror
                <label for="desc">Project description:</label>
                <input type="text" id="description" name="description">
                @error('description')
                    <span style="color:red;">{{$message}}</span>
                @enderror
                <label for="manager">Choose Project Manager:</label>
                <select name="manager" id="manager">
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                    @endforeach
                </select>
                <fieldset>
                    <label for="member">Choose Members:</label>
                    @if($users->isEmpty())
                        <p>No Member is Available</p>
                    @else
                        @foreach($users as $user)
                            <input type="checkbox" name="members[]" value="{{ $user->id }}">{{ $user->name }}<br/>
                        @endforeach
                    @endif
                </fieldset>
                <input type="submit" value="Create a new project">
            </form>
        </div>
    </div>
</div>
@endsection