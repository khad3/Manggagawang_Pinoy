<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next)
    {
        // Check if admin is logged in
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('admin.login.display')
            ->with('error', 'Please login to access the dashboard');
    }

    $timeout = 10 * 60; // 10 minutes
    $lastActivity = session('last_activity_time', now()->timestamp);

    if (now()->timestamp - $lastActivity > $timeout) {
        Auth::guard('admin')->logout();
        session()->flush();
        return redirect()->route('admin.login.display')
            ->with('error', 'You have been logged out due to inactivity.');
    }

    session(['last_activity_time' => now()->timestamp]);

    return $next($request);
}

}