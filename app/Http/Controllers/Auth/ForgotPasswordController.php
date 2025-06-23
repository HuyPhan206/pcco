<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        Log::info('Attempting to send reset link to: ' . $request->email);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
                    ? back()->with('status', 'Chúng tôi đã gửi link đặt lại mật khẩu đến email của bạn!')
                    : back()->withErrors(['email' => 'Không tìm thấy email này trong hệ thống.']);
    }
}
