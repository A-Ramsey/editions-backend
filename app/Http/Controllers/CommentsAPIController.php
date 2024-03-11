<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsAPIController extends Controller
{
    // public function create()
    // {
    //     $validated = request()->validate(Comment::rules());

    //     $comment = Comment::create($validated);

    //     return response()->json($comment);
    // }

    public function update(Comment $comment)
    {
        $validated = request()->validate(Comment::rules());

        $comment->update($validated);

        return $comment;
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return response()->json(['success' => true]);
    }
}
