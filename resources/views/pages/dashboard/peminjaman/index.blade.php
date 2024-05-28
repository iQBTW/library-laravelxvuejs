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
                                        <select class="select2 form-control filter-select" id="filter-status"
                                            style="width: 100%;">
                                            <option value="" selected>Filter Status</option>
                                            <option value="1">Sudah dikembalikan</option>
                                            <option value="0">Belum dikembalikan</option>

                                        </select>
                                    </div>
                                    <div class="form-group px-2">
                                        <select class="select2 form-control" style="width: 100%;">
                                            <option selected>Filter Tanggal Pinjam</option>
                                            <option>Date</option>
                                        </select>
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
        var isReturned = $('#filter-status').val();
        var actionUrl = '{{ url('transactions') }}'
        var apiUrl = '{{ url('api/transactions') }}'

        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                orderable: false,
            },
            {
                data: 'user_name',
                class: 'text-center',
                orderable: true,
            },
            {
                data: 'book_title',
                class: 'text-center',
                orderable: true,
            },
            {
                data: 'qty',
                class: 'text-center',
                orderable: true,
            },
            {
                data: 'isReturned',
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
                data: 'createdAt',
                class: 'text-center',
                orderable: true,
            },
            {
                render: function(index, row, data, meta) {
                    return `<Button class="btn btn-warning" onclick="app.goToEditPage(event, ${meta.row})   ">Edit</Button>
                            <Button class="btn btn-info" onclick="app.goToShowPage(event, ${meta.row})">Detail</Button>
                            <Button class="btn btn-danger" onclick="app.confirmDelete(event, ${data.id})">Delete</Button>`;
                },
                orderable: false,
            },
        ]

        const app = new Vue({
            el: '#app',
            data: {
                datas,
                data,
                isEdit,
                actionUrl,
                apiUrl,
                isReturned,
                columns,
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
                            columns,
                            columnDefs: [{
                                defaultContent: "-",
                                targets: "_all"
                            }],
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
                        _this.isReturned = $('#filter-status').val();
                        console.log(_this.isReturned);
                        _this.table.columns(5).search(_this.isReturned).draw();
                    });
                },
                goToEditPage(event, row) {
                    this.data = this.datas[row]
                    this.actionUrl = '{{ url('transactions') }}' + '/' + this.data.id + '/edit'
                    window.location = this.actionUrl
                },
                goToShowPage(event, row) {
                    this.data = this.datas[row]
                    this.actionUrl = '{{ url('transactions') }}' + '/' + this.data.id
                    window.location = this.actionUrl
                },
                confirmDelete(event, row) {
                    this.data = id
                    $('#confirmDeleteModal').modal()
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
            computed: {
                filteredByStatus() {
                    if (this.filter.statusTrue) {
                        return this.datas.filter(data => data.isReturned === true);
                    } else if (this.filter.statusFalse) {
                        return this.datas.filter(data => data.isReturned === false);
                    } else {
                        return
                    }
                }
            }
        })
    </script>
@endsection
