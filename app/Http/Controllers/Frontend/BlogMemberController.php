<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\RateRequest;
use App\Models\Blog;
use App\Models\Rate;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class BlogMemberController extends Controller
{
    public function index()
    {
        $posts = Blog::withAvg('rates as avg_rate', 'rate')
            ->orderByDesc('created_at')
            ->paginate(3);
        return view('frontend.blog.index', compact('posts'));
    }

    public function show(int $id)
    {
        $post = Blog::findOrFail($id);

        $next = Blog::where('created_at', '>', $post->created_at)
            ->orderBy('created_at', 'asc')->first();

        $prev = Blog::where('created_at', '<', $post->created_at)
            ->orderBy('created_at', 'desc')->first();

        $avgRate = round(Rate::where('id_blog', $id)->avg('rate') ?? 0, 1);

        $userRate = Auth::check()
            ? (Rate::where('id_blog', $id)->where('id_user', Auth::id())->value('rate') ?? 0)
            : 0;

        $comments = Comment::with(['children'])
            ->where('id_blog', $id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.blog.show', compact('post', 'prev', 'next', 'avgRate', 'userRate', 'comments'));
    }

    public function rate(RateRequest $request)
    {
        $validate = $request->validated();

        Rate::updateOrCreate(
            ['id_blog' => $validate['id_blog'], 'id_user' => Auth::id()],
            ['rate'    => $validate['rate']]
        );

        $avg = round(Rate::where('id_blog', $validate['id_blog'])->avg('rate') ?? 0, 1);

        return response()->json([
            'success' => true,
            'avg'     => $avg,
        ]);
    }

    public function comment(CommentRequest $request)
    {

        $user = $request->user();

        $comment = Comment::create([
            'id_blog' => $request->id_blog,
            'id_user' => $user->id,
            'content' => $request->content,
            'avatar_user' => $user->avatar ?? null,
            'name_user'   => $user->name,
            'level'       => $request->filled('parent_id') ? 1 : 0,
            'parent_id'   => $request->parent_id,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id'         => $comment->id,
                'content'    => e($comment->content),
                'name_user'  => $comment->name_user,
                'avatar'     => $comment->avatar_user,
                'created_at' => $comment->created_at->format('H:i'),
                'created_at_full' => $comment->created_at->format('M d, Y'),
                'parent_id'  => $comment->parent_id,
                'level'      => $comment->level,
            ],
        ]);
    }
}
