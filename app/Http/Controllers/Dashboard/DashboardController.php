<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Models\Catalog;
use App\Models\Publisher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $total_users = User::count();
        $total_books = Book::count();
        $total_catalogs = Catalog::count();
        $total_transactions = Transaction::count();
        $total_peminjamans = Transaction::whereMonth('date_start', date('m'))->count();
        $total_publishers = Publisher::count();

        //Donut Chart
        $data_donut = Book::select(DB::raw("COUNT(publisher_id) as total"))
            ->groupBy('publisher_id')
            ->orderBy('publisher_id', 'asc')
            ->pluck('total');

        $label_donut = Publisher::orderBy('publishers.name', 'asc')
            ->join('books', 'publishers.id', '=', 'books.publisher_id')
            ->groupBy('name')
            ->pluck('name');

        $label_bar = ['Peminjaman'];
        $data_bar = [];

        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = 'rgba(60, 141, 188, 0.9)';
            $data_month = [];

            foreach (range(1, 12) as $month) {
                $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_start', $month)->first()->total;
            }

            $data_bar[$key]['data'] = $data_month;
        }

        return view('pages.dashboard.index', compact('total_users', 'total_books', 'total_catalogs', 'total_peminjamans', 'total_publishers', 'total_transactions', 'data_donut', 'label_donut'));
    }
}
