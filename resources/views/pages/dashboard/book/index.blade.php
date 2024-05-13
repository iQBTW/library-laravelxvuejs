@extends('layouts.dashboard')

@section('title')
    Book
@endsection

@section('dashboard-title')
    Book
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Book</li>
@endsection

@section('content')
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Books</h3>
                        </div>

                        <div class="card-body">
                            <div class="justify-content-end pb-2">
                                <a href="#">
                                    <button class="btn btn-primary">Add Book</button>
                                </a>
                            </div>
                            <table id="table" class="table table-bordered table-hover">
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
                                <tbody>
                                    @foreach ($books as $book)
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
                                    @endforeach
                                </tbody>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $('#table').DataTable({
            // ajax: {
            //     url: _this.apiUrl,
            //     type: 'GET'
            // },
            // columns,
            // columnDefs: [{
            //     defaultContent: "-",
            //     targets: "_all"
            // }],
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        })
    </script>
@endsection
