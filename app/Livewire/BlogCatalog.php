<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostCategory;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BlogCatalog extends Component
{
    use WithPagination;

    #[Url(as: 'categoria')]
    public string $category = '';

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function render(): \Illuminate\View\View
    {
        $posts = Post::query()
            ->with(['category', 'author'])
            ->where('is_published', true)
            ->when($this->category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $this->category)))
            ->latest('published_at')
            ->paginate(9);

        $categories = PostCategory::query()
            ->withCount(['posts' => fn ($q) => $q->where('is_published', true)])
            ->whereHas('posts', fn ($q) => $q->where('is_published', true))
            ->get();

        return view('livewire.blog-catalog', compact('posts', 'categories'));
    }
}
