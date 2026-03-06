<x-layouts.app>
    <x-slot name="title">Notícias & Blog</x-slot>

    <section class="bg-gradient-hero pt-36 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image:linear-gradient(rgba(255,255,255,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            <p class="text-primary-400 font-semibold uppercase tracking-widest text-sm mb-4">Fique informado</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-5">Notícias & Blog</h1>
            <p class="text-slate-300 text-lg max-w-xl mx-auto">Artigos, dicas e novidades sobre formação e mercado de trabalho.</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 60" fill="white" preserveAspectRatio="none" class="w-full h-10"><path d="M0,60 C480,0 960,0 1440,60 L1440,60 L0,60 Z"/></svg></div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-2 mb-10">
                <a href="{{ route('blog.index') }}" class="px-4 py-2 rounded-full text-sm font-medium bg-primary-500 text-white">Todos</a>
                @foreach ($categories as $cat)
                <a href="{{ route('blog.index', ['categoria' => $cat->slug]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium bg-slate-100 text-slate-600 hover:bg-primary-50 hover:text-primary-500 transition-colors">
                    {{ $cat->name }} <span class="text-xs opacity-60">({{ $cat->posts_count }})</span>
                </a>
                @endforeach
            </div>

            @if ($posts->isEmpty())
            <div class="text-center py-20 text-slate-400">
                <i class="fa-solid fa-newspaper text-5xl mb-4 opacity-30"></i>
                <p class="font-medium">Nenhum artigo publicado ainda.</p>
            </div>
            @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($posts as $post)
                <article class="group card-hover">
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
                        <span class="flex items-center gap-1"><i class="bi bi-person"></i>{{ $post->author->name ?? '' }}</span>
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
    </section>
</x-layouts.app>
