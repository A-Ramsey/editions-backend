<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class PostsAPIController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Post::with('user')->whereDate('created_at', Date::yesterday())->get();

        return response()->json($posts);
    }

    public function outbox(): JsonResponse
    {
        $posts = Post::where('user_id', Auth::user()->id)->whereDate('created_at', Date::today())->get();

        return response()->json($posts);
    }

    public function create(): JsonResponse
    {
        $validated = request()->validate(Post::rules());

        $post = Post::create($validated);
        $post->user()->associate(Auth::user());
        $post->save();

        return response()->json($post);
    }

    public function update(Post $post): JsonResponse
    {
        if ($post->user == null || $post->user->id != Auth::user()->id) {
            return response()->json(['success' => false, 'message' => 'You do not own this post']);
        }
        $validated = request()->validate(Post::rules());

        $post->content = $validated['content'];
        $post->save();

        return response()->json($post);
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json($post::with('user')->find($post->id));
    }

    public function delete(Post $post) : JsonResponse
    {
        if (Auth::user()->id != $post->user->id) {
            return response()->json(['success' => false, 'message' => 'You don\'t own this post']);
        }
        $post->delete();

        return response()->json(['success' => true, 'message' => 'Post deleted']);
    }
}
