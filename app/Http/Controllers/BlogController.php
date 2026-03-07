<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('pages.blog.index');
    }

    public function show(string $slug): \Illuminate\View\View
    {
        $post = Post::query()
            ->with(['category', 'author'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $related = Post::query()
            ->with('category')
            ->where('post_category_id', $post->post_category_id)
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('pages.blog.show', compact('post', 'related'));
    }
}
