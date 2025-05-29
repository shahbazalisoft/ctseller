<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->is_logged_in == 0){
            auth()->guard('admin')->logout();
        }
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Redirect to login if the user is not authenticated
        // return redirect()->route('login')->with('error', 'You must be logged in as admin to access this page.');
        return redirect()->route('login', ['tab' => 'admin']);
    }
}
