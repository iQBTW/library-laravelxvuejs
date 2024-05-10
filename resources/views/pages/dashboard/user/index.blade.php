@extends('layouts.dashboard')

@section('title')
    User
@endsection

@section('dashboard-title')
    User
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Users</h3>
                        </div>

                        <div class="card-body">
                            <div class="justify-content-end pb-2">
                                <a href="{{ route('user.create') }}">
                                    <button class="btn btn-primary">Add User</button>
                                </a>
                            </div>
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Member</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->gender }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->member }}</td>
                                            <td>
                                                <Button class="btn btn-warning">Edit</Button>
                                                <Button class="btn btn-danger">Delete</Button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Member</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
