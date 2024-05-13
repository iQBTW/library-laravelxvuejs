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
        $publishers = Publisher::all();
        $authors = Author::all();
        $catalogs = Catalog::all();

        return view('pages.dashboard.book.index', compact('publishers', 'authors', 'catalogs'));
    }

    public function api()
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
            'publisher_id' => 'required|numeric|exists:publishers,id',
            'author_id' => 'required|numeric|exists:authors,id',
            'catalog_id' => 'required|numeric|exists:catalogs,id',
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
            'author_id' => 'required|numeric|exists:authors,id',
            'catalog_id' => 'required|numeric|exists:catalogs,id',
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
