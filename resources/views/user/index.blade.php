@extends('layouts.app')

@section('content')
    <div id="header-manage-member" class="col-md-4">
        <h5>Manage Member</h5>
    </div>
    <div class="container wrapper-member-role">
        <div class="row">
            <div class="col-md-5">
                <form action="/user" method="POST">
                    <div class="card">
                        <fieldset>
                            <div>
                                <label>Select Member</label>
                            </div>
                            <hr>
                            @foreach($users as $user)
                            <div>
                                <input type="checkbox" name="users[]" value="{{ $user->name }}">{{ $user->name }}
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
                        <span>
                            Registered Users
                        </span>
                    </div>
                    <hr>
                    <div>
                        <span>Name</span>
                        <span>Email</span>
                        <span>Role</span>
                        <span>Assigned Project</span>
                        <span>Registered Date</span>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
            </div>
        </div>
    </div>
@endsection