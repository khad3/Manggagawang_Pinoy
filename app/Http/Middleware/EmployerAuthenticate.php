<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmployerAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
{
    // Check if employer is logged in
    if (!session()->has('employer_id')) {
        return redirect()->route('employer.login.display')
            ->with('error', 'Please login to see dashboard');
    }

    // 10 minutes inactivity timeout
    $timeout = 10 * 60; // seconds
    $lastActivity = session('last_activity_time', now()->timestamp);

    if (now()->timestamp - $lastActivity > $timeout) {
        session()->flush(); // log out employer
        return redirect()->route('employer.login.display')
            ->with('error', 'You have been logged out due to inactivity.');
    }

    // Update last activity timestamp
    session(['last_activity_time' => now()->timestamp]);

    return $next($request);
}

}
