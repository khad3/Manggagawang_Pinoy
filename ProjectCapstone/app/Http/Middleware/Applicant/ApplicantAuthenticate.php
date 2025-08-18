<?php

namespace App\Http\Middleware\Applicant;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ApplicantAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

      public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('applicant')->check()) {
            return redirect()->route('applicant.login.display')->with('error', 'Please login to see dashboard');
        }

        return $next($request);
    }
}
