<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    /**
     * GET /account/my-product
     * Danh sách sản phẩm của member hiện tại
     */
    public function index()
    {
        $userId = Auth::id();

        $products = Product::where('id_user', $userId)
            ->orderByDesc('id')
            ->paginate(10);

        return view('frontend.product.index', compact('products'));
    }

    /**
     * GET /account/add-product
     * Form tạo sản phẩm
     */
    public function create()
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();
        $brands     = Brand::where('status', 1)->orderBy('name')->get();

        return view('frontend.product.create', compact('categories', 'brands'));
    }

    /**
     * POST /account/add-product
     * Lưu sản phẩm mới
     */
    public function store(ProductRequest $request)
    {
        $user       = Auth::user();
        $data       = $request->validated();
        $data['id_user'] = $user->id;

       
        if ((int) $data['status'] === 0) {
            $data['sale'] = 0;
        }

        $files = $request->file('images', []);
        if (count($files) === 0) {
            return back()
                ->withErrors(['images' => 'Vui lòng chọn ít nhất 1 hình'])
                ->withInput();
        }

        if (count($files) > 3) {
            return back()
                ->withErrors(['images' => 'Chỉ được upload tối đa 3 hình.'])
                ->withInput();
        }

        $basePath = public_path('upload/products/' . $user->id);
        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $filenames = [];

        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $ext      = $file->getClientOriginalExtension();
            $baseName = time() . '_' . Str::random(8) . '.' . $ext;

            // Lưu full
            $file->move($basePath, $baseName);
            $fullPath = $basePath . '/' . $baseName;

            // 85x84
            Image::read($fullPath)
                ->cover(85, 84)
                ->save($basePath . '/85x84_' . $baseName);

            // 329x380
            Image::read($fullPath)
                ->cover(329, 380)
                ->save($basePath . '/329x380_' . $baseName);

            $filenames[] = $baseName;
        }

        $data['image'] = json_encode($filenames);

        Product::create($data);

        return redirect()
            ->route('account.my-product')
            ->with('success', 'Tạo sản phẩm thành công!');
    }

    /**
     * DELETE /account/product/{id}
     */
    public function destroy($id)
    {
        $product = Product::where('id_user', Auth::id())->findOrFail($id);
        $product->delete();

        return back()->with('success', 'Đã xóa sản phẩm.');
    }
}
