<?php

namespace App\Http\Middleware;

use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $tenantId = Auth::user()->tenant_id;

            if (!$tenantId) {
                abort(403, 'Usuário sem tenância definida.');
            }

            TenantContext::setTenantId((int) $tenantId);
        } else {
            TenantContext::setTenantId(null);
        }

        return $next($request);
    }
}
