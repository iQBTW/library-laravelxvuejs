@extends('layouts.dashboard')

@section('title')
    Author
@endsection

@section('dashboard-title')
    Author
@endsection

@section('content')

    <div class="card-header">
        <h3 class="card-title">List of Authors</h3>
    </div>

    <div class="card-body">
        <div class="justify-content-end pb-2">
            <a href="#">
                <button class="btn btn-primary">Add Author</button>
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
            @foreach ($authors as $author)
            <tbody>
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->email }}</td>
                    <td>{{ $author->phone_number }}</td>
                    <td>{{ $author->address }}</td>
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
