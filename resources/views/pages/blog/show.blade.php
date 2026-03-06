<x-layouts.app>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <section class="bg-gradient-hero pt-36 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image:linear-gradient(rgba(255,255,255,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Início</a>
                <i class="bi bi-chevron-right text-xs"></i>
                <a href="{{ route('blog.index') }}" class="hover:text-primary-400 transition-colors">Notícias</a>
                <i class="bi bi-chevron-right text-xs"></i>
                <span class="text-slate-300 truncate max-w-[200px]">{{ $post->title }}</span>
            </nav>
            <div class="flex items-center gap-3 mb-6">
                <span class="bg-primary-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $post->category->name ?? 'Notícia' }}
                </span>
                <span class="text-slate-300 text-sm">{{ $post->published_at?->format('d \d\e F \d\e Y') }}</span>
                <span class="text-slate-400 text-sm flex items-center gap-1">
                    <i class="bi bi-person"></i> {{ $post->author->name ?? '' }}
                </span>
            </div>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white leading-tight">
                {{ $post->title }}
            </h1>
            @if ($post->excerpt)
            <p class="text-slate-300 text-xl mt-5 leading-relaxed">{{ $post->excerpt }}</p>
            @endif
        </div>
        <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 60" fill="white" preserveAspectRatio="none" class="w-full h-10"><path d="M0,60 C480,0 960,0 1440,60 L1440,60 L0,60 Z"/></svg></div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($post->image)
            <div class="rounded-3xl overflow-hidden mb-12 shadow-xl">
                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-80 object-cover">
            </div>
            @endif

            <div class="prose prose-lg prose-slate max-w-none
                prose-headings:font-display prose-headings:text-secondary-900
                prose-a:text-primary-500 prose-a:no-underline hover:prose-a:underline
                prose-img:rounded-2xl prose-blockquote:border-primary-500 prose-blockquote:text-slate-500">
                {!! $post->body !!}
            </div>

            <div class="mt-12 pt-8 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4">
                <a href="{{ route('blog.index') }}" class="btn-outline text-sm">
                    <i class="bi bi-arrow-left"></i> Voltar às notícias
                </a>
                <div class="flex items-center gap-3 text-sm text-slate-400">
                    Partilhar:
                    <a href="#" class="text-slate-400 hover:text-primary-500 transition-colors"><i class="bi bi-facebook text-lg"></i></a>
                    <a href="#" class="text-slate-400 hover:text-primary-500 transition-colors"><i class="bi bi-whatsapp text-lg"></i></a>
                    <a href="#" class="text-slate-400 hover:text-primary-500 transition-colors"><i class="bi bi-linkedin text-lg"></i></a>
                </div>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-display font-bold text-secondary-900 text-2xl mb-8">Artigos relacionados</h2>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach ($related as $rel)
                <article class="group card-hover">
                    <div class="bg-secondary-900 rounded-2xl h-40 overflow-hidden mb-4 flex items-center justify-center">
                        @if ($rel->image)
                        <img src="{{ Storage::url($rel->image) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500">
                        @else
                        <i class="fa-solid fa-newspaper text-white/20 text-4xl"></i>
                        @endif
                    </div>
                    <h3 class="font-display font-bold text-secondary-900 group-hover:text-primary-500 transition-colors">
                        <a href="{{ route('blog.show', $rel->slug) }}">{{ $rel->title }}</a>
                    </h3>
                    <p class="text-xs text-slate-400 mt-2">{{ $rel->published_at?->format('d/m/Y') }}</p>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-layouts.app>
