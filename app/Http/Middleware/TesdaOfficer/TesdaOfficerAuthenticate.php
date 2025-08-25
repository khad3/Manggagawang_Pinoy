<?php

namespace App\Http\Middleware\TesdaOfficer;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TesdaOfficerAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         if (!Auth::guard('tesda_officer')->check()) {
            return redirect()->route('tesda-officer.login.display')->with('error', 'Please login to see dashboard');
        }
        return $next($request);
    }
}
