<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class SearchController extends Controller
{
    // Hiển thị form + xử lý search luôn (method GET)
    public function index(Request $request)
    {
        $q = Product::query();

        // name LIKE
        if ($request->filled('name')) {
            $q->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // price range
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case '0-100':
                    $q->whereBetween('price', [0, 100]);
                    break;
                case '100-200':
                    $q->whereBetween('price', [100, 200]);
                    break;
                case '200-500':
                    $q->whereBetween('price', [200, 500]);
                    break;
                case '500+':
                    $q->where('price', '>=', 500);
                    break;
            }
        }

        // category
        if ($request->filled('category_id')) {
            $q->where('category_id', $request->category_id);
        }

        // brand
        if ($request->filled('brand_id')) {
            $q->where('brand_id', $request->brand_id);
        }

        // status
        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        $products   = $q->orderByDesc('id')
            ->paginate(9)
            ->appends($request->query());

        $categories = Category::all();
        $brands     = Brand::all();

        return view('frontend.product.list', compact(
            'products',
            'categories',
            'brands'
        ));
    }
}
