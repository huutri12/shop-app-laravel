<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    // GET /account/update
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.account.update', compact('user'));
    }

    // POST /account/update
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();
        // không cho sửa email ở đây (nếu muốn thì tách flow verify)
        unset($data['email']);

        // Avatar
        if ($request->hasFile('avatar')) {
            // xóa avatar cũ nếu có
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Password (chỉ cập nhật khi user nhập)
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        unset($data['password']);

        $user->fill($data)->save();

        return back()->with('success', 'Cập nhật tài khoản thành công!');
    }

    // GET /account/my-product
    // public function myProducts()
    // {
    //     // Mẫu: nếu đã có bảng products với cột user_id
    //     $products = Product::where('user_id', Auth::id())
    //         ->latest('id')->paginate(10);

    //     return view('frontend.account.my_product', compact('products'));
    // }

    // GET /account/add-product
    // public function createProduct()
    // {
    //     return view('frontend.account.product_form');
    // }

    // // POST /account/add-product
    // public function storeProduct(ProductRequest $request)
    // {
    //     $data = $request->validated();
    //     $data['user_id'] = Auth::id();

    //     if ($request->hasFile('image')) {
    //         $data['image'] = $request->file('image')->store('products', 'public');
    //     }

    //     Product::create($data);

    //     return redirect()->route('account.my_product')
    //         ->with('success', 'Đã thêm sản phẩm!');
    // }
}
