<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show registration page.
     */
    public function store(Request $request)
{
    $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'middle_name' => ['nullable', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => ['required', 'string', 'max:11', 'unique:users'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
        
    ]);

    $user = User::create([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => 'customer',
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);

    // Role-based redirection
    if ($user->role === 'admin') {
        return redirect('/admin_dashboard');
    } elseif ($user->role === 'rider') {
        return redirect('/rider_dashboard');
    } else {
        return redirect('/dashboard');
    }
}


}
