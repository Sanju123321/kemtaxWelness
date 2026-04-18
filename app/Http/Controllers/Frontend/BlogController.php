<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts   = Post::published()->latest('published_at')->paginate(9);
        $categories = Post::published()->distinct()->pluck('category')->sort()->values();
        $recent  = Post::published()->latest('published_at')->take(5)->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'recent'));
    }

    public function show(string $slug)
    {
        $post    = Post::published()->where('slug', $slug)->firstOrFail();
        $related = Post::published()
                       ->where('id', '!=', $post->id)
                       ->where('category', $post->category)
                       ->latest('published_at')
                       ->take(3)
                       ->get();
        $recent  = Post::published()->latest('published_at')->take(5)->get();

        return view('frontend.blog.show', compact('post', 'related', 'recent'));
    }
}

