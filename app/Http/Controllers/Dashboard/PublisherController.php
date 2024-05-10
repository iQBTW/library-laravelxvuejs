<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Publisher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.dashboard.publisher.index');
    }

    public function api()
    {
        $publishers = Publisher::all();
        $datatables = datatables()->of($publishers)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('pages.dashboard.publisher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:publishers,name',
            'email' => 'required|email|unique:publishers,email',
            'phone_number' => 'required|string|max:16',
            'address' => 'required|string'
        ]);

        Publisher::create($data);

        toastr()->success('Publisher data has been created successfully!');

        return redirect('publishers');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:16',
            'address' => 'required|string'
        ]);

        $publisher->update($data);

        toastr()->success('Publisher Data has been edited successfully!');

        return redirect('publishers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect('publishers');
    }
}
