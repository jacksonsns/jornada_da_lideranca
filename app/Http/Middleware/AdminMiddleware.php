<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->admin) {
            abort(403, 'Acesso não autorizado. Apenas administradores podem acessar esta área.');
        }

        return $next($request);
    }
} 