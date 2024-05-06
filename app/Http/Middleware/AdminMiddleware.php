<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->tipo === 'A') {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Você não tem permissão para acessar esta página.');
    }
}
