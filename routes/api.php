<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * NOTE: WHOLE OF THIS FILE IS api-v1
 *
 * VERCEL CAN'T HANDLE HAVING OTHER /api meant it ended up being /api/api
 * To add a new version of the api add a new routes file and register it in app/Providers/RouteServiceProvider.php
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('posts')->group(function () {
    Route::get('/', [PostsAPIController::class, 'index'])->name('api.v1.posts.create');
    Route::post('create', [PostsAPIController::class, 'create'])->name('api.v1.posts.create');
});
