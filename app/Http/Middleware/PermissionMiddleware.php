<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            abort(403, 'Unauthorized access.');
        }

        // Super Admin bypasses all permission checks
        if ($admin->isSuperAdmin()) {
            return $next($request);
        }

        if (!$admin->hasPermission($permission)) {
            abort(403, 'Access Denied. You do not have the required permission: ' . $permission);
        }

        return $next($request);
    }
}