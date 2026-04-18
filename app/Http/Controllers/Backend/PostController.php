<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('author')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%");
            });
        }

        $posts = $query->paginate(20)->withQueryString();

        $stats = [
            'total'     => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft'     => Post::where('status', 'draft')->count(),
        ];

        return view('backend.posts.index', compact('posts', 'stats'));
    }

    public function create()
    {
        return view('backend.posts.form', ['post' => null]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePost($request);

        $validated['slug']     = Post::generateSlug($validated['title']);
        $validated['admin_id'] = auth('admin')->id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        ActivityLogger::log('post_created', 'Post', $post->id, ['title' => $post->title]);

        return redirect()->route('admin.posts.index')->with('success', 'Post published successfully.');
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('backend.posts.form', compact('post'));
    }

    public function update(Request $request, string $id)
    {
        $post      = Post::findOrFail($id);
        $validated = $this->validatePost($request, $id);

        $validated['slug'] = Post::generateSlug($validated['title'], $post->id);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        ActivityLogger::log('post_updated', 'Post', $post->id, ['title' => $post->title]);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function toggleStatus(string $id)
    {
        $post = Post::findOrFail($id);
        $newStatus = $post->status === 'published' ? 'draft' : 'published';

        $post->update([
            'status'       => $newStatus,
            'published_at' => $newStatus === 'published' ? ($post->published_at ?? now()) : $post->published_at,
        ]);

        return redirect()->back()->with('success', 'Post ' . $newStatus . '.');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        ActivityLogger::log('post_deleted', 'Post', $id, ['title' => $post->title]);

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }

    private function validatePost(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string|max:100',
            'excerpt'        => 'nullable|string|max:500',
            'content'        => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'         => 'required|in:draft,published',
            'published_at'   => 'nullable|date',
        ]);
    }
}
