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
        $transactions = Transaction::with('transactionDetails')
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
            ->get();


        return view('pages.dashboard.peminjaman.index', compact('transactions'));
    }

    public function api(Request $request)
    {
        $transactions = Transaction::with('transactionDetails')
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
            ->get();

        foreach ($transactions as $datas) {
            $datas->isReturned = is_Returned($datas->status);
            $datas->date_start = convertDate($datas->date_start);
            $datas->date_end = convertDate($datas->date_end);
            $datas->createdAt = convertDateTime($datas->created_at);
        }

        if ($request->input('isReturned')) {
            $transactions = $transactions->where('isReturned', $request->input('isReturned'));
        }

        $datatables = datatables()->of($transactions)->addIndexColumn();

        return $datatables->make(true);
    }

    public function filterByStatus(Request $request)
    {
        $getStatus = $request->get('status');
        $transactions = Transaction::all();

        if ($getStatus == true) {
            $transactions = Transaction::with('transactionDetails')
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
                ->get('status' == true);
        } else if ($getStatus == false) {
            $transactions = Transaction::with('transactionDetails')
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
                ->get('status' == false);
        }

        return json_encode($transactions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::all();
        $books = Book::all();

        return view('pages.dashboard.peminjaman.create', compact('users', 'books'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
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
        } catch (Exception $e) {
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

        return view('pages.dashboard.peminjaman.edit', compact('users', 'books', 'transaction'));
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
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            if ($data['status'] == true) {
                $book = Book::findOrFail($data['book_id']);
                $book->qty += $data['qty'];
                $book->save();
            } elseif ($data['status'] == false) {
                $book = Book::findOrFail($data['book_id']);
                $book->qty -= $data['qty'];
                $book->save();
            }

            $transaction->update($data);
            DB::commit();
            return redirect('transactions');
        } catch (Exception $e) {
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
