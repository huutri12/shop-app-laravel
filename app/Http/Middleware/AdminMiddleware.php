<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && Auth::user()->level === User::LEVEL_ADMIN){
            return $next($request);
        }

        if(!Auth::check()){
            return redirect()->route('member.login')
            ->withErrors('Vui long dang nhap de tiep tuc');
        }

        return redirect()->route('member.login')
        ->withErrors('Ban khong co quyen truy cap khu vuc quan tri');
    }
}
