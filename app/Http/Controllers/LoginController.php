<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
       

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Log::info('User logged in: ' . $user->email . ', Role: ' . $user->role . ', Redirecting to: ' . ($user->role === 'admin' ? '/admin/products' : '/'));
            if ($user->role === 'admin') {
                return redirect()->route('admin.products.index');
            }
            return redirect('/');
        }

        return back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
