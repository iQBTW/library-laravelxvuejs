@extends('layouts.dashboard')

@section('title')
    Create New Peminjaman
@endsection

@section('content')
    <div id="app">
        <section class="content">
            <section class="container-fluid">
                <div class="row justify-content-center">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create New Peminjaman</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('transactions.store') }}">
                                @csrf
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
                                        <a href="{{ url('transactions') }}">
                                            <button type="button" class="btn btn-danger">Cancel</button>
                                        </a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </div>
@endsection
@section('js')
    <script>
        var actionUrl = '{{ url('transactions') }}';

        const app = new Vue({
            el: '#app',
            data: {
                book: [{
                    quantity: 1
                }],
            },
            methods: {
                addBook() {
                    this.book.push({
                        quantity: 1
                    })
                }
            }
        })
    </script>
@endsection
