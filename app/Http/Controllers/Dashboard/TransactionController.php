<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionStatus;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactionsToArr = Transaction::all()->toArray();
        $dueTransactions = checkDueTransactions($transactionsToArr);

        return view('pages.dashboard.peminjaman.index', compact('dueTransactions'));
        // if (auth()->user()->role('Admin')) {
        // }
        // else {
        //     return abort(403);
        // }

    }

    public function api(Request $request)
    {
        $status = $request->input('status');
        $datestart = $request->input('date_start');
        $transactions = Transaction::with('users')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transaction_details.book_id', '=', 'books.id')
            ->select(
                'transactions.id as id',
                'transaction_details.id as transaction_details_id',
                'users.id as user_id',
                'books.id as book_id',
                'users.name as user',
                'transaction_details.qty as qty',
                'books.title as book',
                'transactions.status as status',
                'transactions.date_start as date_start',
                'transactions.date_end as date_end',
                'transactions.created_at as created_at',
            )
            ->latest();

        // dd($request->all());

        if (isset($status) or isset($datestart)) {
            if ($datestart != '0') {
                $filterByDateStart = $transactions->whereDate('date_start', $datestart);
                $datatables = datatables()->of($filterByDateStart)
                    ->editColumn('status', function ($data) {
                        $status = is_Returned($data->status);
                        return $status;
                    })
                    ->editColumn('date_start', function ($data) {
                        $formatedDateStart = convertDate($data->date_start);
                        return $formatedDateStart;
                    })
                    ->editColumn('date_end', function ($data) {
                        $formatedDate = convertDate($data->date_end);
                        return $formatedDate;
                    })
                    ->editColumn('created_at', function ($data) {
                        $formatedDate = convertDate($data->created_at);
                        return $formatedDate;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="/transactions/' . $data->id . '/edit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <a href="/transactions/' . $data->id . '" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Detail</a>
                    <a href="/transactions/' . $data->id . '/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>';
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn();
                return $datatables->make(true);
            }
            if ($status != '0') {
                $filterByStatus = $transactions->where('status', $status);
                $datatables = datatables()->of($filterByStatus)
                    // ->editColumn('status', function ($data) {
                    //     $status = is_Returned($data->status);
                    //     return $status;
                    // })
                    ->editColumn('date_start', function ($data) {
                        $formatedDateStart = convertDate($data->date_start);
                        return $formatedDateStart;
                    })
                    ->editColumn('date_end', function ($data) {
                        $formatedDate = convertDate($data->date_end);
                        return $formatedDate;
                    })
                    ->editColumn('created_at', function ($data) {
                        $formatedDate = convertDate($data->created_at);
                        return $formatedDate;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="/transactions/' . $data->id . '/edit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <a href="/transactions/' . $data->id . '" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Detail</a>
                    <a href="/transactions/' . $data->id . '/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>';
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn();
                return $datatables->make(true);
            }
        }
        else {
            $datatables = datatables()->of($transactions)
                // ->editColumn('status', function ($data) {
                //     $status = is_Returned($data->status);
                //     return $status;
                // })
                ->editColumn('date_start', function ($data) {
                    $formatedDateStart = convertDate($data->date_start);
                    return $formatedDateStart;
                })
                ->editColumn('date_end', function ($data) {
                    $formatedDate = convertDate($data->date_end);
                    return $formatedDate;
                })
                ->editColumn('created_at', function ($data) {
                    $formatedDate = convertDate($data->created_at);
                    return $formatedDate;
                })
                ->addColumn('action', function ($data) {
                    return '<a href="/transactions/' . $data->id . '/edit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <a href="/transactions/' . $data->id . '" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Detail</a>
                    <a href="/transactions/' . $data->id . '/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn();

            return $datatables->make(true);
        }

        // dd($transactions->get()->toArray());

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transactionsToArr = Transaction::all()->toArray();
        $dueTransactions = checkDueTransactions($transactionsToArr);

        $users = User::all();
        $books = Book::all();

        return view('pages.dashboard.peminjaman.create', compact('users', 'books', 'dueTransactions'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'book_id' => 'required|exists:books,id',
            'qty' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $transaction = new Transaction();
            $transaction->user_id = $validated['user_id'];
            $transaction->date_start = $validated['date_start'];
            $transaction->date_end = $validated['date_end'];
            $transaction->save();

            $book = Book::findOrFail($validated['book_id']);

            if ($book->qty < $validated['qty']) {
                return redirect('transactions')->with('error', 'Jumlah buku yang dipinjam melebihi stok');
            }

            $transactionDetail = new TransactionDetail();
            $transactionDetail->transaction_id = $transaction->id;
            $transactionDetail->book_id = $book->id;
            $transactionDetail->qty = $validated['qty'];
            $transactionDetail->save();

            $book->qty -= $validated['qty'];
            $book->save();

            DB::commit();
            return redirect('transactions');
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create transaction', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $books = Book::all();
        $users = User::all();
        $transaction = Transaction::with('transactionDetails')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('books', 'transaction_details.book_id', '=', 'books.id')
            ->select(
                'transactions.id as id',
                'transaction_details.id as transaction_details_id',
                'users.id as user_id',
                'books.id as book_id',
                'users.name as user_name',
                'transaction_details.qty as qty',
                'books.title as book_title',
                'transactions.status as status',
                'transactions.date_start as date_start',
                'transactions.date_end as date_end',
                'transactions.created_at as created_at',
            )
            ->findOrFail($transaction->id);

        return view('pages.dashboard.peminjaman.show', compact('users', 'books', 'transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $transactionsToArr = Transaction::all()->toArray();
        $dueTransactions = checkDueTransactions($transactionsToArr);
        $books = Book::all();
        $users = User::all();
        $transaction = Transaction::with('transactionDetails')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('members', 'users.member_id', '=', 'members.id')
            ->join('books', 'transaction_details.book_id', '=', 'books.id')
            ->select(
                'transactions.id as id',
                // 'transaction_details.id as transaction_details_id',
                'members.name as member_name',
                'users.id as user_id',
                'books.id as book_id',
                'users.name as user_name',
                'transaction_details.qty as qty',
                'books.title as book_title',
                'transactions.status as status',
                'transactions.date_start as date_start',
                'transactions.date_end as date_end',
            )
            ->findOrFail($transaction->id);

        return view('pages.dashboard.peminjaman.edit', compact('users', 'books', 'transaction', 'dueTransactions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'book_id' => 'required|exists:books,id',
            'qty' => 'required|numeric|min:1',
            'status' => 'required',
        ]);

        DB::beginTransaction();

        try {
            if ($data['status'] == 'returned') {
                $book = Book::findOrFail($data['book_id']);
                $book->qty += $data['qty'];
                $book->save();
            }
            elseif ($data['status'] == 'not_returned') {
                $book = Book::findOrFail($data['book_id']);
                $book->qty -= $data['qty'];
                $book->save();
            }

            $transaction->update($data);
            DB::commit();
            return redirect('transactions');
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create transaction', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction = Transaction::findOrFail($transaction->id);
        $transaction->delete();

        return redirect('transactions');
    }
}
