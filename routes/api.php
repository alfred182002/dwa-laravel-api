<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\PublicBlogPostController;
use App\Http\Controllers\CommentController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('blog-posts', [BlogPostController::class, 'store']);
});
Route::get('public/blog-posts/{id}', [PublicBlogPostController::class, 'show']);

Route::post('blog-posts', [BlogPostController::class, 'store']);


Route::post('blog-posts/{blogPost}/comments', [CommentController::class, 'store']);

Route::get('blog-posts/{blogPost}/comments', [CommentController::class, 'index']);

Route::get('public/blog-posts', [PublicBlogPostController::class, 'index']);

Route::apiResource('blog-posts', BlogPostController::class);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
