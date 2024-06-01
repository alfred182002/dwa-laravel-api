<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(BlogPost $blogPost)
    {
        return response()->json($blogPost->comments, 200);
    }

    public function store(Request $request, BlogPost $blogPost)
    {
        $validatedData = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $comment = new Comment($validatedData);
        $blogPost->comments()->save($comment);

        return response()->json($comment, 201);
    }
}
