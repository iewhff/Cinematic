<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ClienteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->tipo == 'C') {
            return $next($request);
        }

        $h1 = 'Pedimos Desculpa';
        $title = 'Acesso Negado';
        $msgErro = 'Apenas Cliente tem acesso.';

        return response()->view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'), 403);
    }
}
