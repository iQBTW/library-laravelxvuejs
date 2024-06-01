@extends('layouts.dashboard')

@section('title')
    User
@endsection

@section('dashboard-title')
    User
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Users</h3>
                        </div>

                        <div class="card-body">
                            <div class="justify-content-end pb-2">
                                <a href="{{ url('users/create') }}">
                                    <button class="btn btn-primary">Add User</button>
                                </a>
                            </div>
                            <table id="table" class="table-bordered table-hover table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Member</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->gender }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->member }}</td>
                                            <td>{{ convertDate($user->created_at) }}</td>
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
    </section>
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
        });
        // var datas = []
        // var data = {}
        // var isEdit = false
        // var actionUrl = '{{ url('users') }}'
        // var apiUrl = '{{ url('api/users') }}'


        // var columns = [{
        //         data: 'DT_RowIndex',
        //         class: 'text-center',
        //         orderable: false,
        //     },
        //     {
        //         data: 'name',
        //         class: 'text-center',
        //         orderable: false,
        //     },
        //     {
        //         data: 'email',
        //         class: 'text-center',
        //         orderable: true,
        //     },
        //     {
        //         data: 'gender',
        //         class: 'text-center',
        //         orderable: true,
        //     },
        //     {
        //         data: 'phone_number',
        //         class: 'text-center',
        //         orderable: true,
        //     },
        //     {
        //         data: 'address',
        //         class: 'text-center',
        //         orderable: true,
        //     },
        //     {
        //         data: 'member_id',
        //         class: 'text-center',
        //         orderable: true,
        //     },
        //     {
        //         data: 'date',
        //         class: 'text-center',
        //         orderable: true,
        //     },
        //     {
        //         render: function(index, row, data, meta) {
        //             return `<Button class="btn btn-warning" onclick="app.editData(event, ${meta.row})">Edit</Button>
    //                     <Button class="btn btn-danger" onclick="app.confirmDelete(event, ${data.id})">Delete</Button>`;
        //         },
        //         orderable: false,
        //     },
        // ]

        // const app = new Vue({
        //     el: '#app',
        //     data: {
        //         datas,
        //         data,
        //         isEdit,
        //         actionUrl,
        //         apiUrl,
        //     },
        //     mounted: function() {
        //         this.datatable();
        //     },
        //     methods: {
        //         datatable() {
        //             const _this = this;
        //             _this.table = $('#table').DataTable({
        //                     ajax: {
        //                         url: _this.apiUrl,
        //                         type: 'GET'
        //                     },
        //                     columns,
        //                     columnDefs: [{
        //                         defaultContent: "-",
        //                         targets: "_all"
        //                     }],
        //                     "paging": true,
        //                     "lengthChange": true,
        //                     "searching": true,
        //                     "ordering": true,
        //                     "info": true,
        //                     "autoWidth": false,
        //                     "responsive": true,
        //                 })
        //                 .on('xhr', function() {
        //                     _this.datas = _this.table.ajax.json().data
        //                 });
        //         },
        //         addData() {
        //             this.data = {}
        //             axios.post(this.actionUrl, this.data)
        //                 .then(response => {
        //                     location.reload();
        //                 });
        //             $('#modal-lg').modal()
        //         },
        //         editData(event, row) {
        //             this.data = this.datas[row]
        //             this.isEdit = true
        //             this.actionUrl = '{{ url('publishers') }}' + '/' + this.data.id;
        //             $('#modal-lg').modal()
        //         },
        //         confirmDelete(event, id) {
        //             this.data = id
        //             $('#confirmDeleteModal').modal()
        //         },
        //         deleteData() {
        //             this.actionUrl = '{{ url('publishers') }}' + '/' + this.data;
        //             axios.post(this.actionUrl, {
        //                     _method: 'DELETE'
        //                 })
        //                 .then(response => {
        //                     location.reload();
        //                 })
        //         },
        //         submitForm(event, id) {
        //             event.preventDefault();
        //             const _this = this;
        //             var actionUrl = !this.isEdit ? this.actionUrl : this.actionUrl + '/' + id
        //             axios.post(actionUrl, new FormData($($event.target)[0])).then(response => {
        //                 $('modal-lg').modal('hide')
        //                 _this.table.ajax.reload();
        //             })
        //         },
        //     },
        // })
    </script>
@endsection
