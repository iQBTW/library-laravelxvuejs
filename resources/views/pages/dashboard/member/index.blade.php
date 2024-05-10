@extends('layouts.dashboard')

@section('title')
    Member
@endsection

@section('dashboard-title')
    Member
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Member</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List of Members</h3>
                    </div>

                    <div class="card-body">
                        <div class="justify-content-end pb-2">
                            <a href="#">
                                <button class="btn btn-primary">Add Member</button>
                            </a>
                        </div>
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $member->name }}</td>
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
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
