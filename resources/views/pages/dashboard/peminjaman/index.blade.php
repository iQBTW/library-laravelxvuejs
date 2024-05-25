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
                            <div class="pb-2">
                                <button class="btn btn-primary" @click="addData()">Create New Peminjaman</button>
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
                                    {{-- @foreach ($transactionDetails as $transactionDetail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transactionDetail->user_name }}</td>
                                        <td>{{ $transactionDetail->book_title }}</td>
                                        <td>{{ $transactionDetail->qty }}</td>
                                        <td>{{ upperCase($transactionDetail->status) }}</td>
                                        <td>{{ convertDate($transactionDetail->date_start) }}</td>
                                        <td>{{ convertDate($transactionDetail->date_end) }}</td>
                                        <td>{{ convertDateTime($transactionDetail->created_at) }}</td>
                                        <td>
                                            <Button class="btn btn-warning">Edit</Button>
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

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Peminjaman</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" :action="actionUrl">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="isEdit">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Nama Peminjam</label>
                                    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                        <option value="{{ old('user_id') }}">Nama Peminjam</option>
                                        @foreach ($users as $user)
                                            @if ($user->member_id = 3)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">Date Start</label>
                                    <input type="date" name="date_start"
                                        class="form-control @error('date_start') is-invalid @enderror">

                                    @error('date_start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">Date End</label>
                                    <input type="date" name="date_end"
                                        class="form-control @error('date_end') is-invalid @enderror">

                                    @error('date_end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="book_id">Book</label>
                                    <select name="book_id" class="form-control @error('book_id') is-invalid @enderror">
                                        <option value="{{ old('book_id') }}">Book</option>
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id }}">{{ $book->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('book_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="number" name="qty"
                                        class="form-control @error('qty') is-invalid @enderror" value="1">
                                    @error('qty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this data?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger" @click="deleteData()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var datas = []
        var data = {}
        var isEdit = false
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
                render: function(index, row, data, meta) {
                    return `<Button class="btn btn-warning" onclick="app.editData(event, ${meta.row})">Edit</Button>
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
                        });
                },
                addData() {
                    this.data = {}
                    axios.post(this.actionUrl, this.data)
                        .then(response => {
                            location.reload();
                        });
                    $('#modal-lg').modal()
                },
                // editData(event, row) {
                //     this.data = this.datas[row]
                //     this.isEdit = true
                //     this.actionUrl = '{{ url('transactions') }}' + '/' + this.data.id;
                //     $('#modal-lg').modal()
                // },
                // confirmDelete(event, id) {
                //     this.data = id
                //     $('#confirmDeleteModal').modal()
                // },
                // deleteData() {
                //     this.actionUrl = '{{ url('transactions') }}' + '/' + this.data;
                //     axios.post(this.actionUrl, {
                //             _method: 'DELETE'
                //         })
                //         .then(response => {
                //             location.reload();
                //         })
                // },
                // submitForm(event, id) {
                //     event.preventDefault();
                //     const _this = this;
                //     var actionUrl = !this.isEdit ? this.actionUrl : this.actionUrl + '/' + id
                //     axios.post(actionUrl, new FormData($($event.target)[0])).then(response => {
                //         $('modal-lg').modal('hide')
                //         _this.table.ajax.reload();
                //     })
                // },
            },
        })
        // $('#table').DataTable({
        //     "paging": true,
        //     "lengthChange": true,
        //     "searching": true,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        // })
    </script>
@endsection
