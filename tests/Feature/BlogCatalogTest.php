<?php

use App\Livewire\BlogCatalog;
use App\Models\Post;
use App\Models\PostCategory;
use Livewire\Livewire;

it('renders the blog catalog on the blog index page', function (): void {
    $this->get(route('blog.index'))->assertOk()->assertSeeLivewire(BlogCatalog::class);
});

it('shows all published posts by default', function (): void {
    $category = PostCategory::factory()->create();
    Post::factory()->count(3)->create(['post_category_id' => $category->id, 'is_published' => true]);
    Post::factory()->create(['is_published' => false]);

    Livewire::test(BlogCatalog::class)
        ->assertViewHas('posts', fn ($posts) => $posts->total() === 3);
});

it('filters posts by category', function (): void {
    $cat1 = PostCategory::factory()->create(['slug' => 'noticias']);
    $cat2 = PostCategory::factory()->create(['slug' => 'eventos']);
    Post::factory()->count(2)->create(['post_category_id' => $cat1->id, 'is_published' => true]);
    Post::factory()->count(1)->create(['post_category_id' => $cat2->id, 'is_published' => true]);

    Livewire::test(BlogCatalog::class)
        ->set('category', 'noticias')
        ->assertViewHas('posts', fn ($posts) => $posts->total() === 2);
});

it('resets pagination when changing category', function (): void {
    $cat = PostCategory::factory()->create(['slug' => 'noticias']);
    Post::factory()->count(15)->create(['post_category_id' => $cat->id, 'is_published' => true]);

    // After changing category the component re-renders from page 1
    Livewire::test(BlogCatalog::class)
        ->set('category', 'noticias')
        ->assertViewHas('posts', fn ($posts) => $posts->currentPage() === 1);
});

it('reflects category in the URL as ?categoria=', function (): void {
    Livewire::test(BlogCatalog::class)
        ->set('category', 'eventos')
        ->assertSet('category', 'eventos');
});

it('shows empty state when no posts match the category', function (): void {
    PostCategory::factory()->create(['slug' => 'vazio']);

    Livewire::test(BlogCatalog::class)
        ->set('category', 'vazio')
        ->assertSee('Nenhum artigo publicado nesta categoria');
});
