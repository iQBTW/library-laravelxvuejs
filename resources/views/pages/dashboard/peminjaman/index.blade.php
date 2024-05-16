@extends('layouts.dashboard')

@section('title')
    Peminjaman
@endsection

@section('dashboard-title')
    Peminjaman
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Peminjaman</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List of Transactions</h3>
                    </div>

                    <div class="card-body">
                        <div class="pb-2">
                            <a href="{{ url('transactions/create') }}">
                                <button class="btn btn-primary">Create New Peminjaman</button>
                            </a>
                        </div>
                        <table id="table" class="table-bordered table-hover table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peminjam</th>
                                    <th>Book Title</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Date Start</th>
                                    <th>Date End</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactionDetails as $transactionDetail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transactionDetail->user_name }}</td>
                                        <td>{{ $transactionDetail->book_title }}</td>
                                        <td>{{ $transactionDetail->qty }}</td>
                                        <td>{{ $transactionDetail->status }}</td>
                                        <td>{{ $transactionDetail->date_start }}</td>
                                        <td>{{ $transactionDetail->date_end }}</td>
                                        <td>{{ convertDate($transactionDetail->created_at) }}</td>
                                        <td>
                                            <Button class="btn btn-warning">Edit</Button>
                                            <Button class="btn btn-danger">Delete</Button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        })
    </script>
@endsection
