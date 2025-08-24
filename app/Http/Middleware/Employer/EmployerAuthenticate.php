<?php

namespace App\Http\Middleware\Employer;

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
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::guard('employer')->check()) {
            return redirect()->route('employer.login.display')->with('error', 'Please login to see dashboard');
        }
        return $next($request);
    }
}
