<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class PostsAPIController extends Controller
{
    public function index($date = null): JsonResponse
    {
        if ($date == null) {
            $date = Date::yesterday();
        } else {
            $date = Date::parse($date);
        }
        if ($date > Date::yesterday()) {
            return response()->json(['success' => false, 'message' => 'Day must be older than today']);
        }
        $posts = Post::onDate($date);

        return response()->json($posts);
    }

    public function outbox(): JsonResponse
    {
        $posts = Post::with('user')->with('comments.user')->where('user_id', Auth::user()->id)->whereDate('created_at', Date::today())->get();

        return response()->json($posts);
    }

    public function create(): JsonResponse
    {
        $validated = request()->validate(Post::rules());

        $post = Post::create($validated);
        $post->user()->associate(Auth::user());

        // $images = collect(request()->validate(['images' => 'array']));
        // if ($images->has('images')) {
        //     $images = $images['images'];
        //     foreach ($images as $imgId) {
        //         $image = Image::find($imgId);
        //         if ($image->ownedByAuthUser()) {
        //             $image->imageable()->associate($post);
        //             $image->save();
        //         }
        //     }
        // }

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

        $images = collect(request()->validate(['images' => 'array']));
        $images = $images["images"] ?? collect([]);
        foreach ($images as $imgId) {
            $image = Image::find($imgId)->first();
            if (!$image->ownedByAuthUser()) {
                continue;
            }
            $image->imageable()->associate($post);
            $image->save();
        }

        foreach ($post->images as $image) {
            if (!$images->contains($image->id)) {
                $image->imageable()->dissociate($post);
                $image->save();
                continue;
            }
        }

        $post->save();

        return response()->json($post);
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json($post::with('user')->with('comments.user')->find($post->id));
    }

    public function delete(Post $post): JsonResponse
    {
        if (Auth::user()->id != $post->user->id) {
            return response()->json(['success' => false, 'message' => 'You don\'t own this post']);
        }
        $post->delete();

        return response()->json(['success' => true, 'message' => 'Post deleted']);
    }
}
