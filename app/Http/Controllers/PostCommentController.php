<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    public function __invoke(Post $post)
    {
        $validated = request()->validate(Comment::rules());

        $comment = Comment::create($validated);
        $comment->user()->associate(Auth::user());

        $comment->commentable()->associate($post);
        $comment->save();

        return response()->json($post->fresh());
    }
}
