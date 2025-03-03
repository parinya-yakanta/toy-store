<?php

namespace App\Http\Middleware;

use App\Helpers\QueryHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $check = Auth::check();
        $admin = Auth::user();

        if (! $check) {
            return redirect()->route('auth.login');
        }

        if (! $admin) {
            return redirect()->route('auth.login');
        }
        return $next($request);
    }
}
