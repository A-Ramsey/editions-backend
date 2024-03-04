<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class PostRefreshTimeController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['success' => true, 'refresh-timestamp' => Date::today()->endOfDay()->timestamp]);
    }
}
