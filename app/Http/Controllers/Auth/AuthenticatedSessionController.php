<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login view.
     */
    public function create()
    {
        return view('auth.custom'); // Your custom login/signup Blade
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    $credentials = $request->validate([
        'login' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $loginInput = $credentials['login'];
    $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

    if (Auth::attempt([$fieldType => $loginInput, 'password' => $credentials['password']])) {
        $request->session()->regenerate();

        $user = Auth::user();
        
        // Check if user is suspended
        if ($user->status === 'suspended') {
            // Check if suspension expired
            if ($user->suspension_end_date && now()->gte($user->suspension_end_date)) {
                // Auto-activate expired suspension
                $user->update(['status' => 'active']);
                // Allow login to continue
                return redirect()->intended('/dashboard');
            }
            
            // Log out suspended user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Build suspension message
            $suspensionMessage = 'Your account is suspended';
            if ($user->suspension_end_date) {
                $diff = now()->diffForHumans($user->suspension_end_date, ['parts' => 2]);
                $suspensionMessage .= ' for ' . $diff;
            } else {
                $suspensionMessage .= ' permanently';
            }
            
            if ($user->suspension_message) {
                $suspensionMessage .= '. Reason: ' . $user->suspension_message;
            }
            
            return back()->withErrors([
                'login' => $suspensionMessage,
            ])->onlyInput('login');
        }

        // Role-based redirects
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'rider') {
            return redirect()->intended('/rider/dashboard');
        } else {
            return redirect()->intended('/dashboard');
        }
    }

    return back()->withErrors([
        'login' => 'Invalid email/phone or password.',
    ])->onlyInput('login');
}


    /**
     * Log the user out.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
