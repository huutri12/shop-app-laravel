<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        return view('frontend.cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request)
    {
        // $request->validated();

        $productId = (int) $request->product_id;
        $qty       = (int) ($request->qty ?? 1);

        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $qty;
        } else {
            // decode JSON cột image
            $images = json_decode($product->image, true) ?? [];
            $thumb  = $images[0];

            $cart[$productId] = [
                'id'      => $product->id,
                'name'    => $product->name,
                'price'   => $product->price,
                'qty'     => $qty,
                'image'   => $thumb,
                'id_user' => $product->id_user,
            ];
        }

        session(['cart' => $cart]);

        $totalQty = array_sum(array_column($cart, 'qty'));

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng',
            'count'   => $totalQty,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id'  => 'required|integer',
            'qty' => 'required|integer|min:1',
        ]);

        $id  = $data['id'];
        $qty = $data['qty'];

        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            session(['cart' => $cart]);
        }

        $itemTotal = $cart[$id]['qty'] * $cart[$id]['price'];
        $subTotal  = array_sum(array_map(fn($p) => $p['qty'] * $p['price'], $cart));
        $totalQty  = array_sum(array_column($cart, 'qty'));

        return response()->json([
            'success'    => true,
            'item_total' => $itemTotal,
            'subtotal'   => $subTotal,
            'total_qty'  => $totalQty,
        ]);
    }
    public function delete(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $data['id'];

        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        $subTotal = array_sum(array_map(fn($p) => $p['qty'] * $p['price'], $cart));
        $totalQty = array_sum(array_column($cart, 'qty'));

        return response()->json([
            'success'   => true,
            'subtotal'  => $subTotal,
            'total_qty' => $totalQty,
        ]);
    }
}
