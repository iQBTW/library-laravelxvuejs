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
        <div class="row">
            <div class="col-md-5 offset-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Search from title"
                        v-model="search">
                </div>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" @click="addData()">Create New Book</button>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12" v-for="book in filteredList">
                <div class="info-box" @click="editData(book)">
                    <div class="info-box-content" role="button">
                        <span class="info-box-text h3">@{{ book.title }} </span>
                        <span class="info-box-text">Stock: @{{ book.qty }} </span>
                        <span class="info-box-text bold">Created At: @{{ book.date }}</span>
                        <span class="info-box-number">Rp. @{{ formatNumber(book.price) }},-<small></small></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            @{{ modalTitle }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" :action="actionUrl">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="isEdit">

                            <div class="form-group">
                                <label for="isbn">ISBN</label>
                                <input type="number" name="isbn"
                                    class="form-control @error('isbn') is-invalid @enderror" id="isbn"
                                    placeholder="Enter ISBN" :value="book.isbn">

                                @error('isbn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror" id="title"
                                    placeholder="Enter Title" :value="book.title">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" name="year"
                                    class="form-control @error('year') is-invalid @enderror" id="year"
                                    placeholder="Enter Year" :value="book.year">

                                @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="publisher_id">Publisher</label>
                                <select name="publisher_id"
                                    class="form-control @error('publisher_id') is-invalid @enderror">
                                    <option>Publisher</option>
                                    @foreach ($publishers as $publisher)
                                        <option :selected="book.publisher_id == {{ $publisher->id }}"
                                            value="{{ $publisher->id }}">
                                            {{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @error('publisher_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="form-group">
                                <label for="author_id">Author</label>
                                <select name="author_id" id="author_id"
                                    class="form-control @error('author_id') is-invalid @enderror">
                                    <option>Author</option>
                                    @foreach ($authors as $author)
                                        <option :selected="book.author_id == {{ $author->id }}"
                                            value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @error('author_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="form-group">
                                <label for="catalog_id">Catalog</label>
                                <select name="catalog_id" id="catalog_id"
                                    class="form-control @error('catalog_id') is-invalid @enderror">
                                    <option>Catalog</option>
                                    @foreach ($catalogs as $catalog)
                                        <option :selected="book.catalog_id == {{ $catalog->id }}"
                                            value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @error('catalog_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror"
                                    id="qty" placeholder="Enter Quantity" :value="book.qty">

                                @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price"
                                    class="form-control @error('price') is-invalid @enderror" id="price"
                                    placeholder="Enter Price" :value="book.price">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button type="button" class="btn btn-danger" @click="confirmDelete()"
                                    v-if="isEdit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form :action="actionUrl" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE" v-if="isDelete">

                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this book?
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" @click="deleteData(book.id)">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var datas = []
        var book = {}
        var search = ''
        var actionUrl = '{{ url('books') }}'
        var apiUrl = '{{ url('api/books') }}'
        var isEdit = false
        var isEditBtn = false
        var isDelete = false

        const app = new Vue({
            el: '#app',
            data: {
                datas,
                book,
                search,
                actionUrl,
                apiUrl,
                isEdit,
                isEditBtn,
                isDelete
            },

            mounted: function() {
                this.get_datas();
            },

            methods: {
                get_datas() {
                    const _this = this
                    $.ajax({
                        url: apiUrl,
                        method: 'GET',
                        success: function(data) {
                            _this.datas = JSON.parse(data)
                        },
                        error: function(error) {
                            console.log(error)
                        },
                    });
                },
                addData() {
                    this.book = {}
                    this.isEdit = false
                    axios.post(this.actionUrl, this.book)
                        .then(response => {
                            location.reload();
                        });
                    $('#modal-lg').modal()
                },
                editData(book) {
                    this.book = book
                    this.isEdit = true
                    this.actionUrl = '{{ url('books') }}' + '/' + book.id
                    axios.put(this.actionUrl, this.data, )
                        .then(response => {
                            location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                    $('#modal-lg').modal()
                },
                confirmDelete() {
                    $('#confirmDeleteModal').modal()
                },
                deleteData(id) {
                    this.isEdit = false
                    this.isDelete = true
                    this.actionUrl = '{{ url('books') }}' + '/' + id
                    axios.post(this.actionUrl, )
                        .then(response => {
                            location.reload();
                        })
                },
                formatNumber(x) {
                    return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                },
            },

            computed: {
                filteredList() {
                    return this.datas.filter(book => {
                        return book.title.toLowerCase().includes(this.search.toLowerCase())
                    })
                },
                modalTitle() {
                    return this.isEdit === true ? 'Edit Book' : 'New Book'
                }
            }
        })
    </script>
@endsection
