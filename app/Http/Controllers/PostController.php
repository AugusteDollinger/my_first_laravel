<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    // Display a listing of the resource.

    public function index()
    {
        $posts = Post::join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as user_name')
            ->get(); // Fetch all posts with user data
        return view('posts', compact('posts'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('posts-create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['user_id'] = auth()->id();

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = basename($imagePath); // Store only the image name
        }

        Post::create($validated); // Create a new post

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    // Display the specified resource
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // Show the form for editing the specified resource
    public function edit(Post $post)
    {
        return view('posts-edit', compact('post'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if($request->hasFile('image')) {
            $post->image ? unlink(storage_path('app/public/images/' . $post->image)) : null; // Delete the old image if exists
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = basename($imagePath); // Store only the image name
        }

        $post->update($validated); // Update the post

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Post $post)
    {
        $post->image ? unlink(storage_path('app/public/images/' . $post->image)) : null; // Delete the image if exists

        $post->delete(); // Delete the post

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
