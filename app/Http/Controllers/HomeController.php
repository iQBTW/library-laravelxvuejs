<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 5
        $data5 = TransactionDetail::select('*')
                    ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
                    ->join('books', 'transaction_details.book_id', '=', 'books.id')
                    ->get();

        return $data5;
        return view('home');
    }
}
