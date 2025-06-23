<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class RedirectAfterLogin
{
    public function handle(Request $request, Closure $next)
    {
    $response = $next($request);
    Log::info('User logged in: ' . Auth::user()->email . ', Role: ' . Auth::user()->role);

    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.products.index');
        }
        return redirect('/');
    }
    return $response;
    }
}

