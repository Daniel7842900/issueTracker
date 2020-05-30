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
                            @foreach($users_roles as $user_role)
                            <div>
                                <input type="checkbox" name="userId" value="{{ $user_role->id }}">{{ $user_role->name }}
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
                                <input type="checkbox" name="role_id" value="1">Administrator<br>
                                <input type="checkbox" name="role_id" value="2">Project manager<br>
                                <input type="checkbox" name="role_id" value="3">General user<br>
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
                    </div>
                    <hr>
                    @foreach($users_roles as $user_role)
                    <div>
                        <span>{{ $user_role->name }}</span>
                        <span>{{ $user_role->email }}</span>
                        @if($user_role->role_id == null)
                            <span>Not Assigned</span>
                        @elseif($user_role->role_id != null)
                            
                                @if($user_role->role_id == 1)
                                <span>{{ $user_role->type }}</span>
                                @elseif($user_role->role_id == 2)
                                <span>{{ $user_role->type }}</span>
                                @elseif($user_role->role_id == 3)
                                <span>{{ $user_role->type }}</span>
                                @endif
                            
                        @endif
                        <span>...</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection