<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Author;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.dashboard.author.index', [
            'authors' => Author::paginate(10)
        ]);
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
