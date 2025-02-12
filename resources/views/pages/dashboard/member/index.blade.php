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
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Members</h3>
                        </div>

                        <div class="card-body">
                            <div class="justify-content-end pb-2">
                                <button class="btn btn-primary" @click="addData()">Create New Member</button>
                            </div>
                            <table id="table" class="table-bordered table-hover table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                        <h4 class="modal-title">New Member</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" :action="actionUrl">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="isEdit">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="Enter Name" :value="data.name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
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
                        Are you sure you want to delete this publisher?
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
    <script type="text/javascript">
        var datas = []
        var data = {}
        var isEdit = false
        var actionUrl = '{{ url('members') }}'
        var apiUrl = '{{ url('api/members') }}'


        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                orderable: false,
            },
            {
                data: 'name',
                class: 'text-center',
                orderable: false,
            },
            {
                data: 'date',
                class: 'text-center',
                orderable: false,
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
                    this.isEdit = false
                    axios.post(this.actionUrl, this.data)
                        .then(response => {
                            location.reload();
                        });
                    $('#modal-lg').modal()
                },
                editData(event, row) {
                    this.data = this.datas[row]
                    this.isEdit = true
                    this.actionUrl = '{{ url('members') }}' + '/' + this.data.id;
                    $('#modal-lg').modal()
                },
                confirmDelete(event, id) {
                    this.data = id
                    $('#confirmDeleteModal').modal()
                },
                deleteData() {
                    this.actionUrl = '{{ url('members') }}' + '/' + this.data;
                    axios.post(this.actionUrl, {
                            _method: 'DELETE'
                        })
                        .then(response => {
                            location.reload();
                        })
                },
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
    </script>
@endsection
