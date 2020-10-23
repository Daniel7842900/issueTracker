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
                        <div class="card-header">Select Member</div>
                        <div class="card-body">
                            <fieldset>
                                @foreach($users as $user)
                                <div>
                                    <input type="checkbox" name="userId" value="{{ $user->id }}">{{ $user->name }}
                                </div>
                                @endforeach
                            </fieldset>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Select Role</div>
                        <div class="card-body">
                            <fieldset>
                                <div>
                                    <input type="checkbox" name="role_id" value="1">Administrator<br>
                                    <input type="checkbox" name="role_id" value="2">Project manager<br>
                                    <input type="checkbox" name="role_id" value="3">General user<br>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <input type="submit" value="Assign" id="role-assgin-button">
                </form>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">Registered Users</div>
                    <div class="card-body">
                        <table>
                            <div>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Assigned Project</th>
                                </tr>
                            </div>
                            <div>
                                @foreach($users_info as $user_info)
                                <tr>
                                    <td>{{ $user_info->name }}</td>
                                    <td>{{ $user_info->email }}</td>
                                    @if($user_info->role_id == null)
                                    <td>Not Assigned</td>
                                    @elseif($user_info->role_id != null)
                                        @if($user_info->role_id == 1)
                                        <td>{{ $user_info->type }}</td>
                                        @elseif($user_info->role_id == 2)
                                        <td>{{ $user_info->type }}</td>
                                        @elseif($user_info->role_id == 3)
                                        <td>{{ $user_info->type }}</td>
                                        @endif
                                    @endif
                                    <td>
                                        <select name="" id="">
                                            @foreach($users_projects as $user_project)
                                                @if($user_project->email == $user_info->email)
                                                    @if($user_project->title != null)
                                                    <option value="">{{ $user_project->title }}</option>
                                                    @else
                                                    <option value="">NA</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection