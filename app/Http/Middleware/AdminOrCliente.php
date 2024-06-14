<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrCliente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->tipo === 'F' || Auth::user()->tipo === 'C')) {
            return $next($request);
        }
        return redirect()->route('home')->with('error', 'Você não tem permissão para acessar esta página.');
    }
}
