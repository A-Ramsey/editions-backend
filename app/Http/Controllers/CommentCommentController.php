<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Comment $comment)
    {
        $validated = request()->validate(Comment::rules());

        $newComment = $comment->comments()->create($validated);

        return response()->json($newComment);
    }
}
