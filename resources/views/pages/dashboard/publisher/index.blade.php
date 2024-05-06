@extends('layouts.dashboard')

@section('title')
    Publisher
@endsection

@section('dashboard-title')
    Publisher
@endsection

@section('content')

    <div class="card-header">
        <h3 class="card-title">List of Publishers</h3>
    </div>

    <div class="card-body">
        <div class="justify-content-end pb-2">
            <a href="#">
                <button class="btn btn-primary">Add Publisher</button>
            </a>
        </div>
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach ($publishers as $publisher)
            <tbody>
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $publisher->name }}</td>
                    <td>{{ $publisher->email }}</td>
                    <td>{{ $publisher->phone_number }}</td>
                    <td>{{ $publisher->address }}</td>
                    <td>
                        <Button class="btn btn-warning">Edit</Button>
                        <Button class="btn btn-danger">Delete</Button>
                    </td>
                </tr>
            </tbody>
            @endforeach
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
