<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReactionAPIController extends Controller
{
    public function __invoke(Post $post): JsonResponse
    {
        $post->reactable()->toggle(Auth::user()->id);
        $post->save();

        return response()->json($post);
    }
}
