<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::orderByDesc('id')->paginate(12);
        return view('admin.category.index', compact('items'));
    }

    public function create()
    {
        return view('admin.category.form', ['item' => new Category()]);
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('admin.category.index')->with('success', 'Created!');
    }

    public function edit($id)
    {
        $item = Category::findOrFail($id);
        return view('admin.category.form', compact('item'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $item = Category::findOrFail($id);
        $item->update($request->validated());
        return redirect()->route('admin.category.index')->with('success', 'Updated!');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Deleted!');
    }
}
