<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Author;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
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
        $transactionsToArr = Transaction::with('users')->get()->toArray();
        $dueTransactions = checkDueTransactions($transactionsToArr);

        return view('pages.dashboard.author.index', compact('dueTransactions'));
    }

    public function api()
    {
        $authors = Author::all();

        foreach ($authors as $author) {
            $author->date = convertDateTime($author->created_at);
        }

        $datatables = datatables()->of($authors)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:authors,name',
            'email' => 'required|email|unique:authors,email',
            'phone_number' => 'required|string|max:16',
            'address' => 'required|string',
        ]);

        Author::create($data);

        return redirect('authors');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:16',
            'address' => 'required|string',
        ]);

        $author->update($data);

        return redirect('authors');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect('authors');
    }
}
