<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users = User::select('*')
            ->join('members', 'users.member_id', '=', 'members.id')
            ->select(
                'users.name as name',
                'users.email as email',
                'users.gender as gender',
                'users.address as address',
                'members.name as member',
                'users.created_at as created_at'
            )
            ->orderBy('members.name', 'asc')
            ->get();

        return view('pages.dashboard.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::get();

        return view('pages.dashboard.user.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'gender' => 'required|string',
            'phone_number' => 'required|string|max:16',
            'address' => 'required|string',
            'member_id' => 'required|exists:members,id',
        ]);

        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        User::create($data);

        return redirect('users');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::findOrFail($user->id);
        $user->delete();

        return redirect('users');
    }
}
