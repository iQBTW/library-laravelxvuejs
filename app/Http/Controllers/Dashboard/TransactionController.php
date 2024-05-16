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
        $transactionDetails = TransactionDetail::select('*')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('books', 'transaction_details.book_id', '=', 'books.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select(
                'users.name as user_name',
                'users.id as user_id',
                'transaction_details.id as id',
                'transaction_details.qty as qty',
                'books.id as book_id',
                'books.title as book_title',
                'transactions.status as status',
                'transactions.date_start as date_start',
                'transactions.date_end as date_end',
                'transactions.created_at as created_at',
            )
            ->orderBy('transactions.date_start')
            ->get();

        return view('pages.dashboard.peminjaman.index', compact('transactionDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $books = Book::all();

        $booksJson = json_encode($books);

        return view('pages.dashboard.peminjaman.create', compact('users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_start' => 'required|numeric',
            'date_end' => 'required|numeric|after:date_start',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
