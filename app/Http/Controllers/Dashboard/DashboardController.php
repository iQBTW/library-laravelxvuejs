<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.dashboard.index', [
            'users' => User::count(),
            'books' => Book::count(),
            'publishers' => Publisher::count(),
            'transactions' => Transaction::count(),
        ]);
    }
}
