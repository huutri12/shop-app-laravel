<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    public function showLinkForm()
    {
        return view('frontend.auth.forgot-password');
    }

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Vui lòng kiểm tra email của bạn.')
            : back()->withErrors(['email' => 'Email không tồn tại.']);
    }

    public function showResetForm($token)
    {
        return view('frontend.auth.reset-password', ['token' => $token]);
    }

   public function resetPassword(ResetPasswordRequest $request)
{
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) use ($request) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('member.login')->with('success', 'Đổi mật khẩu thành công!')
        : back()->withErrors(['email' => 'Lỗi reset mật khẩu']);
}
}
