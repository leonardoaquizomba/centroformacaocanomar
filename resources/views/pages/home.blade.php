<x-layouts.app>
    <x-slot name="title">Início</x-slot>

    {{-- ══════════════════════════════════════
         HERO
    ══════════════════════════════════════ --}}
    <section class="relative bg-gradient-hero min-h-screen flex items-center overflow-hidden">

        {{-- Background decorations --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -right-32 w-[600px] h-[600px] rounded-full bg-primary-500/10 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 w-[500px] h-[500px] rounded-full bg-secondary-700/30 blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-primary-500/5 blur-3xl"></div>
            <!-- Grid pattern -->
            <div class="absolute inset-0 opacity-5"
                 style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-20">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Text --}}
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 text-sm text-slate-200 mb-8">
                        <span class="w-2 h-2 bg-primary-400 rounded-full animate-pulse"></span>
                        Formação Profissional Certificada
                    </div>

                    <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                        Invista no seu
                        <span class="text-primary-400">futuro</span>
                        <br>com formação de
                        <span class="text-primary-400">qualidade</span>
                    </h1>

                    <p class="text-slate-300 text-xl leading-relaxed mb-10 max-w-lg">
                        Cursos profissionais certificados em diversas áreas. Aprenda com os melhores professores e abra portas para novas oportunidades.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('courses.index') }}" class="btn-primary text-base px-8 py-4">
                            <i class="fa-solid fa-book-open"></i>
                            Ver Cursos
                        </a>
                        <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white/30 text-white font-semibold rounded-xl hover:border-primary-400 hover:text-primary-400 transition-all duration-200">
                            <i class="bi bi-play-circle"></i>
                            Conhecer Mais
                        </a>
                    </div>

                    {{-- Quick stats --}}
                    <div class="flex flex-wrap gap-8 mt-14 pt-10 border-t border-white/10">
                        <div>
                            <p class="font-display text-3xl font-bold text-white">{{ $stats['students'] ?? '500' }}+</p>
                            <p class="text-slate-400 text-sm mt-1">Alunos Formados</p>
                        </div>
                        <div>
                            <p class="font-display text-3xl font-bold text-white">{{ $stats['courses'] ?? '30' }}+</p>
                            <p class="text-slate-400 text-sm mt-1">Cursos Activos</p>
                        </div>
                        <div>
                            <p class="font-display text-3xl font-bold text-white">{{ $stats['instructors'] ?? '20' }}+</p>
                            <p class="text-slate-400 text-sm mt-1">Instrutores</p>
                        </div>
                        <div>
                            <p class="font-display text-3xl font-bold text-white">98%</p>
                            <p class="text-slate-400 text-sm mt-1">Satisfação</p>
                        </div>
                    </div>
                </div>

                {{-- Hero visual --}}
                <div class="hidden lg:flex justify-center relative">
                    <div class="relative w-[420px] h-[420px]">
                        <!-- Main card -->
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl flex items-center justify-center shadow-2xl">
                            <i class="fa-solid fa-graduation-cap text-white" style="font-size: 140px; opacity: 0.15;"></i>
                        </div>

                        <!-- Floating cards -->
                        <div class="absolute -top-6 -left-10 bg-white rounded-2xl p-4 shadow-2xl flex items-center gap-3 animate-bounce" style="animation-duration:3s">
                            <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-certificate text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-900 text-sm">Certificados</p>
                                <p class="text-xs text-slate-500">Reconhecidos</p>
                            </div>
                        </div>

                        <div class="absolute -bottom-6 -right-10 bg-white rounded-2xl p-4 shadow-2xl flex items-center gap-3 animate-bounce" style="animation-duration:4s; animation-delay:1s">
                            <div class="w-10 h-10 bg-secondary-900 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-users text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-secondary-900 text-sm">Turmas Online</p>
                                <p class="text-xs text-slate-500">e Presenciais</p>
                            </div>
                        </div>

                        <div class="absolute top-1/2 -right-14 -translate-y-1/2 bg-primary-500 rounded-2xl p-4 shadow-2xl text-white animate-bounce" style="animation-duration:3.5s; animation-delay:0.5s">
                            <p class="font-display font-bold text-2xl">98%</p>
                            <p class="text-xs text-primary-100">Aprovação</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="white" preserveAspectRatio="none" class="w-full h-16">
                <path d="M0,80 C480,0 960,0 1440,80 L1440,80 L0,80 Z"/>
            </svg>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         CATEGORIES STRIP
    ══════════════════════════════════════ --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-3">Áreas de Formação</p>
                <h2 class="section-title">Explore as nossas categorias</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                <a href="{{ route('courses.index', ['categoria' => $category->slug]) }}"
                   class="group flex flex-col items-center p-5 rounded-2xl border border-slate-100 hover:border-primary-200 hover:bg-primary-50 transition-all duration-200 card-hover text-center">
                    <div class="w-12 h-12 bg-primary-100 group-hover:bg-primary-500 rounded-xl flex items-center justify-center mb-3 transition-colors duration-200">
                        <i class="fa-solid fa-layer-group text-primary-500 group-hover:text-white transition-colors duration-200"></i>
                    </div>
                    <span class="font-semibold text-secondary-900 text-sm leading-snug">{{ $category->name }}</span>
                    <span class="text-xs text-slate-400 mt-1">{{ $category->courses_count }} curso{{ $category->courses_count != 1 ? 's' : '' }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         FEATURED COURSES
    ══════════════════════════════════════ --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
                <div>
                    <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-3">Em Destaque</p>
                    <h2 class="section-title">Cursos mais procurados</h2>
                    <p class="section-subtitle">Formações práticas e certificadas nas áreas com maior procura no mercado.</p>
                </div>
                <a href="{{ route('courses.index') }}" class="btn-outline shrink-0">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($featuredCourses as $course)
                <article class="bg-white rounded-2xl overflow-hidden border border-slate-100 card-hover group">
                    {{-- Course image --}}
                    <div class="relative h-48 bg-gradient-to-br from-secondary-800 to-secondary-900 overflow-hidden">
                        @if ($course->image)
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->name }}"
                                 class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fa-solid fa-book-open text-white/20" style="font-size:72px;"></i>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="bg-primary-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $course->category->name ?? '' }}
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="bg-white/90 text-secondary-900 text-xs font-bold px-3 py-1 rounded-full">
                                {{ $course->modality === 'presencial' ? 'Presencial' : ($course->modality === 'online' ? 'Online' : 'Misto') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="font-display font-bold text-secondary-900 text-lg mb-2 group-hover:text-primary-500 transition-colors">
                            <a href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a>
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-5 line-clamp-2">
                            {{ $course->description ? strip_tags($course->description) : 'Formação profissional certificada.' }}
                        </p>

                        <div class="flex items-center gap-4 text-xs text-slate-400 mb-5">
                            <span class="flex items-center gap-1.5">
                                <i class="bi bi-clock text-primary-400"></i>
                                {{ $course->duration_hours }}h
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i class="bi bi-bar-chart text-primary-400"></i>
                                {{ ucfirst($course->level) }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i class="bi bi-patch-check text-primary-400"></i>
                                Certificado
                            </span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <div>
                                <p class="text-xs text-slate-400">A partir de</p>
                                <p class="font-display font-bold text-primary-500 text-xl">
                                    {{ number_format($course->price, 0, ',', '.') }} <span class="text-sm font-medium">Kz</span>
                                </p>
                            </div>
                            <a href="{{ route('courses.show', $course->slug) }}" class="btn-primary text-sm py-2.5 px-5">
                                Saber mais
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         WHY CANOMAR
    ══════════════════════════════════════ --}}
    <section class="py-20 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Left visual --}}
                <div class="relative">
                    <div class="bg-gradient-hero rounded-3xl p-10 relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-500/20 rounded-full blur-2xl"></div>
                        <div class="grid grid-cols-2 gap-5">
                            @php $reasons = [
                                ['icon'=>'fa-certificate','label'=>'Certificação Reconhecida','value'=>'100%'],
                                ['icon'=>'fa-users','label'=>'Alunos Formados','value'=>'500+'],
                                ['icon'=>'fa-chalkboard-user','label'=>'Professores Especializados','value'=>'20+'],
                                ['icon'=>'fa-briefcase','label'=>'Parceiros Empresariais','value'=>'15+'],
                            ]; @endphp
                            @foreach ($reasons as $r)
                            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/20 text-white">
                                <i class="fa-solid {{ $r['icon'] }} text-primary-400 text-2xl mb-3"></i>
                                <p class="font-display font-bold text-3xl">{{ $r['value'] }}</p>
                                <p class="text-slate-300 text-sm mt-1">{{ $r['label'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right text --}}
                <div>
                    <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-3">Porquê a Canomar?</p>
                    <h2 class="section-title mb-5">A formação certa para o seu crescimento</h2>
                    <p class="text-slate-500 leading-relaxed mb-8">
                        Com anos de experiência no mercado angolano, oferecemos formação de qualidade superior com certificados reconhecidos e metodologias modernas adaptadas à realidade local.
                    </p>

                    @php $features = [
                        ['icon'=>'bi-patch-check-fill','color'=>'text-primary-500','title'=>'Certificação Oficial','desc'=>'Certificados reconhecidos pelo mercado de trabalho angolano.'],
                        ['icon'=>'bi-people-fill','color'=>'text-secondary-600','title'=>'Turmas Reduzidas','desc'=>'Aprendizagem personalizada com acompanhamento individual.'],
                        ['icon'=>'bi-laptop','color'=>'text-primary-500','title'=>'Modalidade Flexível','desc'=>'Escolha entre presencial, online ou misto conforme a sua disponibilidade.'],
                        ['icon'=>'bi-headset','color'=>'text-secondary-600','title'=>'Suporte Dedicado','desc'=>'Apoio contínuo durante e após a formação.'],
                    ]; @endphp

                    <div class="space-y-5">
                        @foreach ($features as $f)
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                                <i class="bi {{ $f['icon'] }} {{ $f['color'] }} text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-secondary-900 mb-1">{{ $f['title'] }}</h4>
                                <p class="text-slate-500 text-sm">{{ $f['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <a href="{{ route('about') }}" class="btn-secondary mt-10">
                        Conhecer a nossa história <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         STATS BANNER
    ══════════════════════════════════════ --}}
    <section class="bg-gradient-primary py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
                @foreach ([
                    ['icon'=>'fa-user-graduate','value'=>($stats['students'] ?? '500').'+ ','label'=>'Alunos Formados'],
                    ['icon'=>'fa-book','value'=>($stats['courses'] ?? '30').'+','label'=>'Cursos Disponíveis'],
                    ['icon'=>'fa-chalkboard-user','value'=>($stats['instructors'] ?? '20').'+','label'=>'Instrutores'],
                    ['icon'=>'fa-certificate','value'=>($stats['certificates'] ?? '400').'+','label'=>'Certificados Emitidos'],
                ] as $s)
                <div>
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-white/20 rounded-2xl mb-4">
                        <i class="fa-solid {{ $s['icon'] }} text-2xl"></i>
                    </div>
                    <p class="font-display font-bold text-4xl">{{ $s['value'] }}</p>
                    <p class="text-primary-100 text-sm mt-2">{{ $s['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         TESTIMONIALS
    ══════════════════════════════════════ --}}
    @if($testimonials->isNotEmpty())
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-3">Testemunhos</p>
                <h2 class="section-title">O que dizem os nossos alunos</h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($testimonials as $testimonial)
                <div class="bg-white rounded-2xl p-7 border border-slate-100 card-hover relative">
                    <i class="fa-solid fa-quote-left text-primary-200 text-4xl absolute top-6 right-6"></i>
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <i class="fa-solid fa-star text-primary-400 text-sm"></i>
                        @endfor
                    </div>
                    <p class="text-slate-600 leading-relaxed mb-6 text-sm">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center gap-3">
                        @if ($testimonial->photo_path)
                        <img src="{{ Storage::url($testimonial->photo_path) }}" alt="{{ $testimonial->name }}"
                             class="w-11 h-11 rounded-full object-cover">
                        @else
                        <div class="w-11 h-11 bg-gradient-primary rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <p class="font-semibold text-secondary-900 text-sm">{{ $testimonial->name }}</p>
                            <p class="text-xs text-slate-400">{{ $testimonial->role }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════
         LATEST BLOG
    ══════════════════════════════════════ --}}
    @if($posts->isNotEmpty())
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
                <div>
                    <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-3">Notícias & Blog</p>
                    <h2 class="section-title">Últimos artigos</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="btn-outline shrink-0">Ver todos <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                <article class="group card-hover">
                    <div class="bg-secondary-900 rounded-2xl h-48 overflow-hidden mb-5">
                        @if($post->image)
                        <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                             class="w-full h-full object-cover opacity-80 group-hover:scale-105 group-hover:opacity-100 transition-all duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fa-solid fa-newspaper text-white/20 text-5xl"></i>
                        </div>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                            <span class="bg-primary-50 text-primary-500 font-medium px-3 py-1 rounded-full">
                                {{ $post->category->name ?? 'Notícia' }}
                            </span>
                            <span>{{ $post->published_at?->format('d/m/Y') }}</span>
                        </div>
                        <h3 class="font-display font-bold text-secondary-900 mb-2 group-hover:text-primary-500 transition-colors">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-2">{{ $post->excerpt }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}"
                           class="inline-flex items-center gap-2 text-primary-500 font-semibold text-sm mt-4 hover:gap-3 transition-all">
                            Ler mais <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════
         CTA BANNER
    ══════════════════════════════════════ --}}
    <section class="py-20 bg-secondary-900 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-secondary-700/30 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-3xl mx-auto px-4 text-center">
            <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6">
                Pronto para começar a sua formação?
            </h2>
            <p class="text-slate-300 text-lg mb-10">
                Inscreva-se hoje e dê o primeiro passo para uma carreira de sucesso.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('courses.index') }}" class="btn-primary text-base px-8 py-4">
                    <i class="fa-solid fa-graduation-cap"></i> Ver Cursos Disponíveis
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white/30 text-white font-semibold rounded-xl hover:border-primary-400 hover:text-primary-400 transition-all duration-200">
                    <i class="bi bi-chat-dots"></i> Falar Connosco
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
