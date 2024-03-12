<?php

use App\Http\Controllers\CommentCommentController;
use App\Http\Controllers\CommentsAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAPIController;
use App\Http\Controllers\LoginAPIController;
use App\Http\Controllers\PostsAPIController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\ReactionAPIController;
use App\Http\Controllers\PostRefreshTimeController;

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

Route::get('post-refresh-time', PostRefreshTimeController::class)->name('api.v1.expiry-time');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostsAPIController::class, 'index'])->name('api.v1.posts.index');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('create', [PostsAPIController::class, 'create'])->name('api.v1.posts.create');
        Route::get('outbox', [PostsAPIController::class, 'outbox'])->name('api.v1.posts.outbox');
    });
    Route::prefix('{post}')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::patch('update', [PostsAPIController::class, 'update'])->name('api.v1.posts.update');
            Route::delete('delete', [PostsAPIController::class, 'delete'])->name('api.v1.posts.delete');
            Route::post('react', ReactionAPIController::class)->name('api.v1.posts.react');
            Route::post('comment', PostCommentController::class)->name('api.v1.posts.comment');
        });
        Route::get('/', [PostsAPIController::class, 'show'])->name('api.v1.posts.show');
    });
});

Route::prefix('comments')->group(function () {
    Route::prefix('{comment}')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::patch('update', [CommentsAPIController::class, 'update'])->name('api.v1.comments.update');
            Route::delete('delete', [CommentsAPIController::class, 'delete'])->name('api.v1.comments.delete');
            Route::post('comment', CommentCommentController::class)->name('api.v1.comments.comment.create');
        });
    });
});

Route::prefix('user')->group(function () {
    Route::post('create', [UserAPIController::class, 'store'])->name('api.v1.users.create');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::patch('edit', [UserAPIController::class, 'update'])->name('api.v1.users.edit');
    });
});

Route::post('login', LoginAPIController::class);
