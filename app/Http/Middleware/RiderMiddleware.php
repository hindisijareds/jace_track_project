<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'rider') {
    return $next($request);
}

if ($request->expectsJson()) {
    return response()->json(['message' => 'Unauthorized'], 403);
}

return redirect('/login')->with('error', 'Access denied.');

    }
}
