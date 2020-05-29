@extends('layouts.app')

@section('content')
    <div id="header-manage-member" class="col-md-4">
        <h5>Manage Member</h5>
    </div>
    <div class="container wrapper-member-role">
        <div class="row">
            <div class="col-md-5">
                <form action="{{route('user.update')}}" method="POST">
                    @csrf
                    <div class="card">
                        <fieldset>
                            <div>
                                <label>Select Member</label>
                            </div>
                            <hr>
                            @foreach($users as $user)
                            <div>
                                <input type="checkbox" name="userId" value="{{ $user->id }}">{{ $user->name }}
                            </div>
                            @endforeach
                        </fieldset>
                    </div>
                    <div class="card">
                        <fieldset>
                            <div>
                                <label>Select Role</label>
                            </div>
                            <hr>
                            <div>
                                <input type="checkbox" name="role" value="admin">Administrator<br>
                                <input type="checkbox" name="role" value="manager">Project manager<br>
                                <input type="checkbox" name="role" value="user">General user<br>
                            </div>
                        </fieldset>
                    </div>
                    <input type="submit" value="Assign" id="role-assgin-button">
                </form>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div>
                        <label for="">Registered Users</label>
                    </div>
                    <hr>
                    <div>
                        <span>Name</span>
                        <span>Email</span>
                        <span>Role</span>
                        <span>Assigned Project</span>
                        <span>Registered Date</span>
                    </div>
                    <hr>
                    @foreach($users as $user)
                    <div>
                        <span>{{ $user->name }}</span>
                        <span>{{ $user->email }}</span>
                        @if($user->role == null)
                            <span>Not Assigned</span>
                        @else($user->role != null)
                            <span>{{ $user->role }}</span>
                        @endif
                        <span>{{ $user->project_id }}</span>
                        <span>{{ $user->created_at }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection