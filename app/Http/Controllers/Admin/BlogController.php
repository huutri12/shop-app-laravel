<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $blogs = Blog::when($q, fn($s) => $s->where('title', 'like', "%{$q}%"))
            ->orderBy('id', 'asc')
            ->get();
        return view('admin.blog.index', compact('blogs', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $data = $request->only(['title', 'description', 'content']);

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $newName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/blog'), $newName);
            $data['image'] = $newName;
        } else {
            $data['image'] = null;
        }

        Blog::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->only('title', 'image', 'description', 'content');

        if ($request->hasFile('image')) {

            $newImage = $this->storeImage($request->file('image'));

            $this->deleteImage($blog->image);

            $data['image'] = $newImage;
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Blog::findOrFail($id)->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Deleted successfully.');
    }

    // Lưu file ảnh vào public/upload/blog và trả về TÊN FILE để lưu DB
    private function storeImage($file): string
    {
        $dir = public_path('upload/blog');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        $file->move($dir, $name);

        return $name;
    }

    // Xóa file ảnh cũ trong public/upload/blog nếu tồn tại
    private function deleteImage(?string $filename): void
    {
        if (!$filename) return;

        $path = public_path('upload/blog/' . $filename);
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
