<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
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

        return view('pages.dashboard.member.index', compact('dueTransactions'));
    }

    public function api()
    {
        $members = Member::all();

        foreach ($members as $member) {
            $member->date = convertDate($member->created_at);
        }

        $datatables = datatables()->of($members)->addIndexColumn();

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
            'name' => 'required|string|unique:publishers,name',
        ]);

        Member::create($data);

        return redirect('members');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:publishers,name',
        ]);

        $member->update($data);

        return redirect('members');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect('members');
    }
}
