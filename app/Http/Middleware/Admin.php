<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Đảm bảo import đúng

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}