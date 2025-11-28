<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\User;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;

class CheckoutController extends Controller
{
    public function index()
    {

        $cart = session('cart', []);

        if (empty($cart) && !session('success')) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng đang trống.');
        }

        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        return view('frontend.checkout.index', compact('cart', 'subtotal'));
    }

    // Xử lý nút đặt hàng:
    public function order(CheckoutRequest  $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng trống, không thể đặt hàng');
        }

        $data = $request->validated();

        if (!auth()->check()) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            Auth::login($user);
        } else {
            $user = auth()->user();
        }

        $totalPrice = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));

        // Lưu history
        History::create([
            'email'   => $user->email,
            'phone'   => $data['phone'],
            'name'    => $user->name,
            'id_user' => $user->id,
            'price'   => $totalPrice,
        ]);

        Mail::to($user->email)->send(
            new OrderMail($user, $cart, $totalPrice, $data)
        );

        session()->forget('cart');

        return redirect()->route('checkout.index')
            ->with('success', 'Chúc mừng, bạn đã đặt hàng thành công!');
    }
}
