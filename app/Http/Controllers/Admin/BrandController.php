<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
      public function index() {
        $items = Brand::orderByDesc('id')->paginate(12);
        return view('admin.brand.index', compact('items'));
    }

    public function create() {
        return view('admin.brand.form', ['item' => new Brand()]);
    }

    public function store(BrandRequest $request) {
        Brand::create($request->validated());
        return redirect()->route('admin.brand.index')->with('success','Created!');
    }

    public function edit($id) {
        $item = Brand::findOrFail($id);
        return view('admin.brand.form', compact('item'));
    }

    public function update(BrandRequest $request, $id) {
        $item = Brand::findOrFail($id);
        $item->update($request->validated());
        return redirect()->route('admin.brand.index')->with('success','Updated!');
    }

    public function destroy($id) {
        Brand::findOrFail($id)->delete();
        return back()->with('success','Deleted!');
    }
}
