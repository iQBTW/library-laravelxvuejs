@extends('layouts.dashboard')

@section('title')
    Book
@endsection

@section('dashboard-title')
    Book
@endsection

@section('content')

    <div class="card-header">
        <h3 class="card-title">List of Catalogs</h3>
    </div>

    <div class="card-body">
        <div class="justify-content-end pb-2">
            <a href="#">
                <button class="btn btn-primary">Add Book</button>
            </a>
        </div>
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Publisher</th>
                    <th>Author</th>
                    <th>Catalog</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach ($books as $book)
            <tbody>
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->year }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->catalog }}</td>
                    <td>{{ $book->qty }}</td>
                    <td>{{ $book->price }}</td>
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
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Publisher</th>
                    <th>Author</th>
                    <th>Catalog</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
