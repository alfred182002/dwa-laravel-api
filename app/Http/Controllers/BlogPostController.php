<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index()
    {
        return BlogPost::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        $blogPost = BlogPost::create($validatedData);

        if ($blogPost->image) {
            $blogPost->image = Storage::url($blogPost->image);
        }
        return response()->json($blogPost, 201);
    }

    public function show($id)
    {
        return BlogPost::find($id);
    }

    public function update(Request $request, $id)
    {
        $blogPost = BlogPost::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($blogPost->image) {
                Storage::disk('public')->delete($blogPost->image);
            }

            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        $blogPost->update($validatedData);

        return response()->json($blogPost, 200);
    }

    public function destroy($id)
    {
        $blogPost = BlogPost::findOrFail($id);

        // Eliminar la imagen asociada si existe
        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image);
        }

        $blogPost->delete();

        return response()->json(null, 204);
    }
}
