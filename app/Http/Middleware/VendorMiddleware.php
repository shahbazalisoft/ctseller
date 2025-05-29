<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (Auth::guard('vendor')->check()) {
            if (!auth('vendor')->user()->status) {
                auth()->guard('vendor')->logout();
                return redirect()->route('login', ['tab' => 'store']);
            }
            return $next($request);
        } elseif (Auth::guard('vendor_employee')->check()) {
            if (Auth::guard('vendor_employee')->user()->is_logged_in == 0) {
                auth()->guard('vendor_employee')->logout();
                return redirect()->route('login', ['tab' => 'store']);
            }

            if (!auth('vendor_employee')->user()->store->status) {
                auth()->guard('vendor_employee')->logout();
                return redirect()->route('login', ['tab' => 'store']);
            }
            return $next($request);
        }

        return redirect()->route('login', ['tab' => 'store']);
    }
}
