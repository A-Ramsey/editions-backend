<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function create(): JsonResponse
    {
        $validated = request()->validate([
            'content' => 'string|max:1000|min:1'
        ]);

        $post = Post::create($validated);
        $post->user()->associate(Auth::user());
        $post->save();

        return response()->json($post);
    }
}
