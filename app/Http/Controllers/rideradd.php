<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class rideradd extends Controller
{
    public function index()
    {
        // Fetch riders correctly
        $riders = User::where('role', 'rider')->get();
        return view('rideradd', compact('riders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        // Create rider in USERS TABLE
        User::create([
            'first_name' => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'role'       => 'rider',
            'status'     => 'active',
        ]);

        return redirect()->back()->with('success', 'Rider added successfully!');
    }
}
