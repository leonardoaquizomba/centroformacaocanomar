<div>
    {{-- Category filter pills --}}
    <div class="flex flex-wrap gap-2 mb-10">
        <button
            wire:click="$set('category', '')"
            class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ $category === '' ? 'bg-primary-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-primary-50 hover:text-primary-500' }}"
        >
            Todos
        </button>

        @foreach ($categories as $cat)
        <button
            wire:key="cat-{{ $cat->slug }}"
            wire:click="$set('category', '{{ $cat->slug }}')"
            class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ $category === $cat->slug ? 'bg-primary-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-primary-50 hover:text-primary-500' }}"
        >
            {{ $cat->name }} <span class="text-xs opacity-60">({{ $cat->posts_count }})</span>
        </button>
        @endforeach
    </div>

    {{-- Posts grid with fade transition --}}
    <div
        class="transition-opacity duration-300 ease-in-out"
        wire:loading.class="opacity-0"
        wire:loading.class.remove="opacity-100"
        wire:target="$set, gotoPage, nextPage, previousPage"
    >
        @if ($posts->isEmpty())
        <div class="text-center py-20 text-slate-400">
            <i class="fa-solid fa-newspaper text-5xl mb-4 opacity-30"></i>
            <p class="font-medium">Nenhum artigo publicado nesta categoria.</p>
        </div>
        @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($posts as $post)
            <article wire:key="post-{{ $post->id }}" class="group card-hover">
                <div class="bg-secondary-900 rounded-2xl h-52 overflow-hidden mb-5">
                    @if ($post->image)
                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                         class="w-full h-full object-cover opacity-80 group-hover:scale-105 group-hover:opacity-100 transition-all duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fa-solid fa-newspaper text-white/20 text-5xl"></i>
                    </div>
                    @endif
                </div>
                <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                    <span class="bg-primary-50 text-primary-500 font-medium px-3 py-1 rounded-full">
                        {{ $post->category->name ?? 'Notícia' }}
                    </span>
                    <span>{{ $post->published_at?->format('d/m/Y') }}</span>
                    <span class="flex items-center gap-1">
                        <i class="bi bi-person"></i>{{ $post->author->name ?? '' }}
                    </span>
                </div>
                <h2 class="font-display font-bold text-secondary-900 text-lg mb-2 group-hover:text-primary-500 transition-colors">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                <a href="{{ route('blog.show', $post->slug) }}"
                   class="inline-flex items-center gap-2 text-primary-500 font-semibold text-sm hover:gap-3 transition-all">
                    Ler artigo <i class="bi bi-arrow-right"></i>
                </a>
            </article>
            @endforeach
        </div>

        <div class="mt-12">{{ $posts->links() }}</div>
        @endif
    </div>
</div>
