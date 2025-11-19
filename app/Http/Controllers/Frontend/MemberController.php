<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MemberLoginRequest;
use App\Http\Requests\MemberRegisterRequest;
use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;


class MemberController extends Controller
{
    public function index()
    {
        $latestProducts = Product::orderByDesc('created_at')
            ->take(6)
            ->get();


        $latestPosts = Blog::orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('frontend.index', compact('latestProducts', 'latestPosts'));
    }
    public function showLogin()
    {
        return view('frontend.member.login');
    }

    public function login(MemberLoginRequest $request)
    {
        $login = [
            'email'    => $request->email,
            'password' => $request->password,
            'level'    => User::LEVEL_MEMBER,
        ];

        $remember = $request->boolean('remember_me');

        if (Auth::attempt($login, $remember)) {
            $request->session()->regenerate();

            return redirect()->to('/')
                ->with('success', 'Đăng nhập thành công, xin chào ' . auth()->user()->name . '!');
        }

        return back()
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng!'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('member.login');
    }

    public function showRegister()
    {
        return view('frontend.member.register');
    }

    public function register(MemberRegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => $request->password,
            'id_country' => $request->id_country,
            'avatar' => $request->avatar,
            'level'    => User::LEVEL_MEMBER,
        ]);

        Auth::login($user);

        return redirect()->to('/')
            ->with('success', 'Đăng ký thành công!');
    }
}
