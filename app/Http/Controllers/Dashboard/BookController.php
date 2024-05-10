<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Models\Author;
use App\Models\Catalog;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::select('*')
            ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('catalogs', 'books.catalog_id', '=', 'catalogs.id')
            ->select(
                'books.isbn as isbn',
                'books.title as title',
                'books.year as year',
                'publishers.name as publisher',
                'authors.name as author',
                'catalogs.name as catalog',
                'books.qty as qty',
                'books.price as price',
            )
            ->orderBy('books.year')
            ->get();

        return view('pages.dashboard.book.index', compact('books'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
