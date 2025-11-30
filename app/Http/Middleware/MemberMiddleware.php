<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        
        if (Auth::check() && Auth::user()->level === User::LEVEL_MEMBER) {
            return $next($request);
        }

        // Chưa login -> bắt login member
        if (!Auth::check()) {
            return redirect()
                ->route('member.login')
                ->withErrors('Vui lòng đăng nhập để tiếp tục');
        }

        // Đăng nhập rồi nhưng là admin -> đá về admin
        return redirect()
            ->route('admin.dashboard')
            ->withErrors('Tài khoản admin không dùng được khu vực thành viên.');
    }
}
