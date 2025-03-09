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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $check = Auth::check();

        if (! $check) {
            Auth::logout();
            return redirect()->route('login');
        }

        return $next($request);
    }
}
