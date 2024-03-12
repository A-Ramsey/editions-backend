<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ImageAPIController extends Controller
{
    public function upload(): JsonResponse
    {
        $files = request()->files;

        $images = collect();

        foreach ($files as $file) {
            $images->push(Image::store($file));
        }

        return response()->json($images);
    }
}
