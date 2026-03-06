<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;

class BlogController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $activeCategory = request()->query('categoria');

        $posts = Post::query()
            ->with('category')
            ->where('is_published', true)
            ->when($activeCategory, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $activeCategory)))
            ->latest('published_at')
            ->paginate(9)
            ->appends(request()->query());

        $categories = PostCategory::query()
            ->withCount(['posts' => fn ($q) => $q->where('is_published', true)])
            ->whereHas('posts', fn ($q) => $q->where('is_published', true))
            ->get();

        return view('pages.blog.index', compact('posts', 'categories', 'activeCategory'));
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
