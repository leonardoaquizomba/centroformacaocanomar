<x-layouts.app>
    <x-slot name="title">Sobre Nós</x-slot>

    {{-- Hero --}}
    <section class="bg-gradient-hero pt-36 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image:linear-gradient(rgba(255,255,255,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            <p class="text-primary-400 font-semibold uppercase tracking-widest text-sm mb-4">A Nossa História</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-5">Sobre o Centro Canomar</h1>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto">
                Comprometidos com a excelência na formação profissional em Angola, transformando vidas através do conhecimento.
            </p>
        </div>
        <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 60" fill="white" preserveAspectRatio="none" class="w-full h-10"><path d="M0,60 C480,0 960,0 1440,60 L1440,60 L0,60 Z"/></svg></div>
    </section>

    {{-- Mission & Vision --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-4">Quem Somos</p>
                    <h2 class="section-title mb-6">Formação que transforma carreiras</h2>
                    <p class="text-slate-500 leading-relaxed mb-6">
                        O Centro de Formação Canomar é uma instituição de referência em Angola, dedicada à formação profissional de qualidade. Com uma equipa de instrutores altamente qualificados e metodologias modernas, preparamos os nossos alunos para os desafios do mercado de trabalho.
                    </p>
                    <p class="text-slate-500 leading-relaxed mb-8">
                        Desde a nossa fundação, já formámos centenas de profissionais em diversas áreas, sempre com foco na excelência, na prática e na aplicabilidade real dos conhecimentos adquiridos.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-5">
                        @foreach ([
                            ['icon'=>'bi-bullseye','color'=>'text-primary-500','bg'=>'bg-primary-50','title'=>'Missão','desc'=>'Proporcionar formação profissional de excelência que capacite os angolanos para o mercado de trabalho.'],
                            ['icon'=>'bi-eye','color'=>'text-secondary-600','bg'=>'bg-secondary-50','title'=>'Visão','desc'=>'Ser o centro de formação de referência em Angola, reconhecido pela qualidade e impacto social.'],
                        ] as $item)
                        <div class="bg-slate-50 rounded-2xl p-5">
                            <div class="w-10 h-10 {{ $item['bg'] }} rounded-xl flex items-center justify-center mb-3">
                                <i class="bi {{ $item['icon'] }} {{ $item['color'] }} text-lg"></i>
                            </div>
                            <h4 class="font-semibold text-secondary-900 mb-2">{{ $item['title'] }}</h4>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    @foreach ([
                        ['icon'=>'fa-user-graduate','value'=>'500+','label'=>'Alunos Formados','bg'=>'bg-gradient-primary'],
                        ['icon'=>'fa-book','value'=>'30+','label'=>'Cursos Activos','bg'=>'bg-gradient-hero'],
                        ['icon'=>'fa-certificate','value'=>'98%','label'=>'Taxa de Aprovação','bg'=>'bg-gradient-hero'],
                        ['icon'=>'fa-chalkboard-user','value'=>'20+','label'=>'Instrutores','bg'=>'bg-gradient-primary'],
                    ] as $stat)
                    <div class="{{ $stat['bg'] }} rounded-2xl p-7 text-white text-center">
                        <i class="fa-solid {{ $stat['icon'] }} text-3xl opacity-80 mb-3"></i>
                        <p class="font-display font-bold text-3xl">{{ $stat['value'] }}</p>
                        <p class="text-sm opacity-80 mt-1">{{ $stat['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-3">Os Nossos Valores</p>
                <h2 class="section-title">O que nos guia</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['icon'=>'bi-stars','title'=>'Excelência','desc'=>'Padrões de qualidade elevados em tudo o que fazemos.'],
                    ['icon'=>'bi-people-fill','title'=>'Inclusão','desc'=>'Formação acessível a todos, sem barreiras.'],
                    ['icon'=>'bi-lightbulb','title'=>'Inovação','desc'=>'Metodologias modernas e adaptadas ao mercado.'],
                    ['icon'=>'bi-shield-check','title'=>'Integridade','desc'=>'Transparência e ética em todas as nossas acções.'],
                ] as $value)
                <div class="bg-white rounded-2xl p-7 text-center border border-slate-100 card-hover">
                    <div class="w-14 h-14 bg-primary-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <i class="bi {{ $value['icon'] }} text-primary-500 text-2xl"></i>
                    </div>
                    <h4 class="font-display font-bold text-secondary-900 mb-3">{{ $value['title'] }}</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $value['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Team --}}
    @if ($teachers->isNotEmpty())
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-3">A Nossa Equipa</p>
                <h2 class="section-title">Os nossos instrutores</h2>
                <p class="section-subtitle mx-auto">Profissionais experientes e apaixonados pelo que fazem.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($teachers as $teacher)
                <div class="bg-white rounded-2xl border border-slate-100 p-7 text-center card-hover">
                    <div class="w-20 h-20 bg-gradient-primary rounded-full flex items-center justify-center mx-auto mb-5 text-white font-display font-bold text-2xl">
                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                    </div>
                    <h4 class="font-display font-bold text-secondary-900">{{ $teacher->name }}</h4>
                    @if ($teacher->teacherProfile?->specialization)
                    <p class="text-primary-500 font-medium text-sm mt-1">{{ $teacher->teacherProfile->specialization }}</p>
                    @endif
                    @if ($teacher->teacherProfile?->bio)
                    <p class="text-slate-400 text-sm mt-3 leading-relaxed line-clamp-3">{{ $teacher->teacherProfile->bio }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="py-16 bg-gradient-primary text-white text-center">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="font-display text-3xl font-bold mb-4">Pronto para começar?</h2>
            <p class="text-primary-100 mb-8">Explore os nossos cursos e dê o primeiro passo para a sua nova carreira.</p>
            <a href="{{ route('courses.index') }}" class="btn-secondary">
                <i class="fa-solid fa-graduation-cap"></i> Ver Cursos
            </a>
        </div>
    </section>
</x-layouts.app>
