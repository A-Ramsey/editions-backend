<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentReactionAPIController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Comment $comment)
    {
        $comment->reactable()->toggle(Auth::user()->id);
        $comment->save();

        return response()->json($comment);
    }
}
