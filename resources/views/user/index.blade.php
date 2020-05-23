@extends('layouts.app')

@section('content')
    <div id="header-manage-member" class="col-md-4">
        <h5>Manage Member</h5>
    </div>
    <div class="container wrapper-container">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div>
                        <span>Select Member</span>
                    </div>
                    <hr>
                    <div>
                        <p>Daniel</p>
                        <p>Klarissa</p>
                        <p>Keenan</p>
                        <p>Kevinn</p>
                        <p>Luna</p>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <span>
                            Select Role
                        </span>
                    </div>
                    <hr>
                    <div>
                        <p>Project Manager</p>
                        <p>General Developer</p>
                    </div>
                </div>
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
                <button id="role-assgin-button">Assign</button>
            </div>
        </div>
    </div>
@endsection