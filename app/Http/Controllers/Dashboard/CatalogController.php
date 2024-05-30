<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Catalog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
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
        $catalogs = Catalog::get();

        $transactionsToArr = Transaction::with('users')->get()->toArray();
        $dueTransactions = checkDueTransactions($transactionsToArr);

        return view('pages.dashboard.catalog.index', compact('catalogs', 'dueTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transactionsToArr = Transaction::with('users')->get()->toArray();
        $dueTransactions = checkDueTransactions($transactionsToArr);

        return view('pages.dashboard.catalog.create', compact('dueTransactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:name'
        ]);

        Catalog::create($data);
        return redirect()->route('catalog.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Catalog $catalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalog $catalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Catalog $catalog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalog $catalog)
    {
        //
    }
}
