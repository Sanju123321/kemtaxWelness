<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display all blog posts.
     */
    public function index()
    {
        // $posts = Post::where('status', 'published')->latest()->paginate(9);

        return view('frontend.blog.index');
    }

    /**
     * Display a single blog post.
     */
    public function show(string $slug)
    {
        // $post = Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
        // $related = Post::where('status', 'published')->where('id', '!=', $post->id)->take(3)->get();

        return view('frontend.blog.show');
    }
}
