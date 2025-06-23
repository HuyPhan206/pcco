<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check() || !Auth::user()->is_staff || !Auth::user()->hasRole($role)) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}