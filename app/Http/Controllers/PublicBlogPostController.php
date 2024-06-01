<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class PublicBlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::all(['title', 'content', 'image', 'created_at']);
        return response()->json($blogPosts);
    }

    public function show($id)
    {
        $blogPost = BlogPost::with('comments')->findOrFail($id);
        return response()->json($blogPost);
    }
}
