<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;


class BlogApiController extends Controller
{
    // GET /api/blogs  -> lấy tất cả bài blog
    public function index()
    {
        $blogs = Blog::orderByDesc('created_at')->get();

        return response()->json([
            'status' => true,
            'data' => $blogs
        ]);
    }

    // GET /api/blogs/{id} -> chi tiết 1 bài
    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status'  => false,
                'message' => 'Blog not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $blog,
        ]);
    }

    // POST /api/blogs -> tạo mới
    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        $blog = Blog::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Created successfully',
            'data'    => $blog,
        ], 201);
    }
    // PUT/PATCH /api/blogs/{id} -> update
    public function update(BlogRequest $request, $id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status'  => false,
                'message' => 'Blog not found',
            ], 404);
        }

        $data = $request->validated();

        $blog->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Updated successfully',
            'data'    => $blog,
        ]);
    }

    // DELETE /api/blogs/{id} -> xóa
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'status'  => false,
                'message' => 'Blog not found',
            ], 404);
        }

        $blog->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
