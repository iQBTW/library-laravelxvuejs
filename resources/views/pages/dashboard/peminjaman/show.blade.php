@extends('layouts.dashboard')

@section('title')
    Detail Peminjaman
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{ route('transactions.index') }}">Peminjaman</a></li>
    <li class="breadcrumb-item">Detail Peminjaman</li>
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
                                <h3 class="card-title">Detail Peminjaman</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Nama Peminjam</label>
                                    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                        @foreach ($users as $user)
                                            @if ($user->member_name !== 'Admin' && $user->id == $transaction->user_id ?? old('user_id'))
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
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="form-group w-50">
                                        <label for="name">Date Start</label>
                                        <input type="date" name="date_start"
                                            class="form-control @error('date_start') is-invalid @enderror"
                                            value="{{ $transaction->date_start ?? old('date_start') }}">

                                        @error('date_start')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="align-content-center mt-3 px-2">
                                        <span class="text-center text-lg font-bold"> / </span>
                                    </div>
                                    <div class="form-group w-50">
                                        <label for="name">Date End</label>
                                        <input type="date" name="date_end"
                                            class="form-control @error('date_end') is-invalid @enderror"
                                            value="{{ $transaction->date_end ?? old('date_end') }}">

                                        @error('date_end')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="book_id">Book</label>
                                    <select name="book_id" class="form-control @error('book_id') is-invalid @enderror">
                                        @foreach ($books as $book)
                                            @if ($book->id == $transaction->book_id ?? old('book_id'))
                                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                                            @endif
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
                                        class="form-control @error('qty') is-invalid @enderror"
                                        value="{{ $transaction->qty }}">
                                    @error('qty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">Status Peminjaman</label>
                                    <Select class="form-control" name="status">
                                        @if ($transaction->status == 'not_returned')
                                            <option value="{{ $transaction->status }}">Belum dikembalikan</option>
                                        @elseif($transaction->status == 'returned')
                                            <option value="{{ $transaction->status }}">Sudah dikembalikan</option>
                                        @endif
                                    </Select>
                                    @error('qty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <a href="{{ url('transactions') }}">
                                        <button type="button" class="btn btn-danger">Close</button>
                                    </a>
                                </div>
                            </div>
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
