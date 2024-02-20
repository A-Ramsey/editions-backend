<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Date;

class PostsAPIController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Post::whereDate('created_at', Date::yesterday())->get();

        return response()->json($posts);
    }

    public function create(): JsonResponse
    {
        $validated = request()->validate([
            'name' => 'string|max:255|min:1',
            'content' => 'string|max:1000|min:1'
        ]);

        $post = Post::create($validated);
        $post->save();

        return response()->json($post);
    }
}
