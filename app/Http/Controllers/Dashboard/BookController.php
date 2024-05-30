<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Models\Author;
use App\Models\Catalog;
use App\Models\Publisher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
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
        $publishers = Publisher::all();
        $authors = Author::all();
        $catalogs = Catalog::all();

        $transactionsToArr = Transaction::with('users')->get()->toArray();
        $dueTransactions = checkDueTransactions($transactionsToArr);

        return view('pages.dashboard.book.index', compact('publishers', 'authors', 'catalogs', 'dueTransactions'));
    }

    public function api()
    {
        $books = Book::select('*')
            ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('catalogs', 'books.catalog_id', '=', 'catalogs.id')
            ->select(
                'books.id as id',
                'books.isbn as isbn',
                'books.title as title',
                'books.year as year',
                'publishers.id as publisher_id',
                'publishers.name as publisher',
                'authors.id as author_id',
                'authors.name as author',
                'catalogs.id as catalog_id',
                'catalogs.name as catalog',
                'books.qty as qty',
                'books.price as price',
                'books.created_at as created_at',
            )
            ->orderBy('books.year')
            ->get();

        foreach ($books as $book) {
            $book->date = convertDate($book->created_at);
        }

        return json_encode($books);
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
            'isbn' => 'required|numeric|unique:books,isbn',
            'title' => 'required|string|unique:books,title',
            'year' => 'required|numeric',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'catalog_id' => 'required|exists:catalogs,id',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        Book::create($data);

        return redirect('books');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'isbn' => 'required|numeric',
            'title' => 'required|string',
            'year' => 'required|numeric',
            'publisher_id' => 'required|numeric|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'catalog_id' => 'required|exists:catalogs,id',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $book->update($data);

        return redirect('books');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('books');
    }
}
