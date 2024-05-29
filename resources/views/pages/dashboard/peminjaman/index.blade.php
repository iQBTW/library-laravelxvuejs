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
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Transactions</h3>
                        </div>

                        <div class="card-body">
                            <div class="pb-2 d-flex items-center justify-content-between">
                                <div class="form-group">
                                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                                        Create New Peminjaman
                                    </a>
                                </div>
                                <div class="d-flex">
                                    <div class="form-group px-2">
                                        <select class="select2 form-control filter-select" name="status" id="filter-status" v-model="filterStatus" style="width: 100%;" @change="datatable">
                                            <option value="" selected>Filter Status</option>
                                            <option value="Sudah dikembalikan">Sudah dikembalikan</option>
                                            <option value="Belum dikembalikan">Belum dikembalikan</option>
                                        </select>
                                    </div>
                                    <div class="form-group px-2">
                                        <input type="text" class="form-control filter-input-date" id="filter-date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Filter Date">
                                    </div>
                                </div>
                            </div>
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
                                {{-- @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->user_name }}</td>
                                        <td>{{ $transaction->book_title }}</td>
                                        <td>{{ $transaction->qty }}</td>
                                        <td>{{ is_Returned($transaction->status) }}</td>
                                        <td>{{ convertDate($transaction->date_start) }}</td>
                                        <td>{{ convertDate($transaction->date_end) }}</td>
                                        <td>{{ convertDateTime($transaction->created_at) }}</td>
                                        <td>
                                            <a href="{{ route('transactions.edit', $transaction->id) }}">

                                                <Button class="btn btn-warning">Edit</Button>
                                            </a>
                                            <a href="{{ route('transactions.show', $transaction->id) }}">

                                                <Button class="btn btn-info">Detail</Button>
                                            </a>
                                            <Button class="btn btn-danger">Delete</Button>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        // $('#table').DataTable({
        //     "paging": true,
        //     "lengthChange": true,
        //     "searching": true,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        // })
        var datas = []
        var data = {}
        var isEdit = false
        var filterStatus = ''
        var actionUrl = '{{ url('transactions') }}'
        var apiUrl = '{{ url('api/transactions') }}'

        const app = new Vue({
            el: '#app',
            data: {
                datas,
                data,
                isEdit,
                filterStatus,
                actionUrl,
                apiUrl,
            },
            mounted: function() {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#table').DataTable({
                            ajax: {
                                url: _this.apiUrl,
                                type: 'GET'
                            },
                            columns: [
                                {
                                    data: 'DT_RowIndex',
                                    class: 'text-center',
                                    orderable: false,
                                },
                                {
                                    data: 'user',
                                    class: 'text-center',
                                    orderable: true,
                                },
                                {
                                    data: 'book',
                                    class: 'text-center',
                                    orderable: true,
                                },
                                {
                                    data: 'qty',
                                    class: 'text-center',
                                    orderable: true,
                                },
                                {
                                    data: 'status',
                                    class: 'text-center',
                                    orderable: true,
                                },
                                {
                                    data: 'date_start',
                                    class: 'text-center',
                                    orderable: true,
                                },
                                {
                                    data: 'date_end',
                                    class: 'text-center',
                                    orderable: true,
                                },
                                {
                                    data: 'created_at',
                                    class: 'text-center',
                                    orderable: true,
                                },
                                {
                                    data: 'action',
                                    class: 'text-center',
                                    orderable: true,
                                },

                            ],
                            columnDefs: [{
                                defaultContent: "-",
                                targets: 0,
                            }],
                            // "serverSide": true,
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                        })
                        .on('xhr', function() {
                            _this.datas = _this.table.ajax.json().data
                        })
                    $('.filter-select').change(function() {
                        let isReturned = $('#filter-status').val()
                        _this.table.data(5).search(isReturned).draw();
                    })
                    $('.filter-input-date').change(function() {
                        let dateStart = $('#filter-date').val()
                        _this.table.data(6).search(dateStart).draw();
                    });
                },
                deleteData() {
                    this.actionUrl = '{{ url('transactions') }}' + '/' + this.data
                    axios.post(this.actionUrl, {
                            _method: 'DELETE'
                        })
                        .then(response => {
                            location.reload();
                        })
                },
                filterTrue() {
                    this.filter.datas
                }
            },
        })
    </script>
@endsection
