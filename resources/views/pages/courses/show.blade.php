<x-layouts.app>
    <x-slot name="title">{{ $course->name }}</x-slot>

    {{-- Hero --}}
    <section class="bg-gradient-hero pt-36 pb-0 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image:linear-gradient(rgba(255,255,255,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative pb-20">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Início</a>
                <i class="bi bi-chevron-right text-xs"></i>
                <a href="{{ route('courses.index') }}" class="hover:text-primary-400 transition-colors">Cursos</a>
                <i class="bi bi-chevron-right text-xs"></i>
                <span class="text-slate-200">{{ $course->name }}</span>
            </nav>

            <div class="grid lg:grid-cols-5 gap-12 items-start">
                <div class="lg:col-span-3">
                    <span class="inline-block bg-primary-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-5">
                        {{ $course->category->name ?? 'Formação' }}
                    </span>
                    <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-5 leading-tight">
                        {{ $course->name }}
                    </h1>
                    <p class="text-slate-300 text-lg leading-relaxed mb-8">
                        {{ $course->description ? strip_tags($course->description) : '' }}
                    </p>

                    <div class="flex flex-wrap gap-5">
                        <div class="flex items-center gap-2 text-slate-300 text-sm">
                            <i class="bi bi-clock text-primary-400 text-lg"></i>
                            <span><strong class="text-white">{{ $course->duration_hours }}h</strong> de formação</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-300 text-sm">
                            <i class="bi bi-bar-chart text-primary-400 text-lg"></i>
                            <span>Nível <strong class="text-white">{{ $course->level->getLabel() }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-300 text-sm">
                            <i class="bi bi-laptop text-primary-400 text-lg"></i>
                            <span><strong class="text-white">{{ $course->modality->getLabel() }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-300 text-sm">
                            <i class="bi bi-patch-check text-primary-400 text-lg"></i>
                            <span>Certificado incluído</span>
                        </div>
                    </div>
                </div>

                {{-- Enroll card --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl p-7 shadow-2xl">
                        @if ($course->image)
                        <img src="{{ Storage::url($course->image) }}" alt="{{ $course->name }}"
                             class="w-full h-44 object-cover rounded-2xl mb-6">
                        @else
                        <div class="h-44 bg-gradient-to-br from-secondary-800 to-secondary-900 rounded-2xl mb-6 flex items-center justify-center">
                            <i class="fa-solid fa-book-open text-white/20 text-5xl"></i>
                        </div>
                        @endif

                        <div class="mb-6">
                            <p class="text-xs text-slate-400 mb-1">Preço do curso</p>
                            <p class="font-display font-bold text-primary-500 text-4xl">
                                {{ number_format($course->price, 0, ',', '.') }}
                                <span class="text-xl text-slate-400 font-medium">Kz</span>
                            </p>
                        </div>

                        <a href="#inscrever" class="btn-primary w-full justify-center text-base py-4 mb-3">
                            <i class="fa-solid fa-pen-to-square"></i> Inscrever-me agora
                        </a>
                        <a href="{{ route('contact') }}" class="btn-outline w-full justify-center text-sm py-3">
                            <i class="bi bi-chat-dots"></i> Tenho dúvidas
                        </a>

                        <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-3 text-center text-xs text-slate-500">
                            <div><i class="bi bi-shield-check text-green-500 text-lg block mb-1"></i>Inscrição segura</div>
                            <div><i class="bi bi-award text-primary-500 text-lg block mb-1"></i>Certificado oficial</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 60" fill="white" preserveAspectRatio="none" class="w-full h-10"><path d="M0,60 C480,0 960,0 1440,60 L1440,60 L0,60 Z"/></svg></div>
    </section>

    {{-- Course details --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    {{-- Description --}}
                    @if ($course->description)
                    <div class="prose prose-slate max-w-none mb-12">
                        <h2 class="font-display text-2xl font-bold text-secondary-900 mb-5">Sobre o curso</h2>
                        {!! $course->description !!}
                    </div>
                    @endif

                    {{-- Prerequisites --}}
                    @if ($course->prerequisites)
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-10">
                        <h3 class="font-semibold text-amber-800 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-list-check"></i> Pré-requisitos
                        </h3>
                        <p class="text-amber-700 text-sm">{{ $course->prerequisites }}</p>
                    </div>
                    @endif

                    {{-- Available classes --}}
                    @if ($course->classes->isNotEmpty())
                    <div class="mb-12">
                        <h2 class="font-display text-2xl font-bold text-secondary-900 mb-6">Turmas Disponíveis</h2>
                        <div class="space-y-4">
                            @foreach ($course->classes as $class)
                            <div class="border border-slate-100 rounded-2xl p-6 hover:border-primary-200 hover:bg-primary-50/30 transition-all">
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div>
                                        <h4 class="font-semibold text-secondary-900">{{ $class->name }}</h4>
                                        <div class="flex flex-wrap gap-4 mt-2 text-sm text-slate-400">
                                            <span><i class="bi bi-calendar3 mr-1.5 text-primary-400"></i>{{ $class->start_date?->format('d/m/Y') }} – {{ $class->end_date?->format('d/m/Y') }}</span>
                                            <span><i class="bi bi-people mr-1.5 text-primary-400"></i>{{ $class->max_students }} vagas</span>
                                            @foreach ($class->schedules as $sched)
                                            <span><i class="bi bi-clock mr-1.5 text-primary-400"></i>{{ $sched->day_of_week->getLabel() }} {{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($sched->end_time)->format('H:i') }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <a href="#inscrever" class="btn-primary text-sm py-2.5 px-5 shrink-0">Inscrever</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar info --}}
                <div>
                    <div class="bg-slate-50 rounded-2xl p-6 sticky top-28">
                        <h3 class="font-display font-bold text-secondary-900 mb-5">Informações do Curso</h3>
                        <ul class="space-y-4 text-sm">
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500 flex items-center gap-2"><i class="bi bi-clock text-primary-400"></i>Duração</span>
                                <span class="font-semibold text-secondary-900">{{ $course->duration_hours }} horas</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500 flex items-center gap-2"><i class="bi bi-bar-chart text-primary-400"></i>Nível</span>
                                <span class="font-semibold text-secondary-900">{{ $course->level->getLabel() }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500 flex items-center gap-2"><i class="bi bi-laptop text-primary-400"></i>Modalidade</span>
                                <span class="font-semibold text-secondary-900">{{ $course->modality->getLabel() }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500 flex items-center gap-2"><i class="bi bi-patch-check text-primary-400"></i>Certificação</span>
                                <span class="font-semibold text-secondary-900">{{ $course->certification_type ?: 'Sim' }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500 flex items-center gap-2"><i class="bi bi-tag text-primary-400"></i>Categoria</span>
                                <span class="font-semibold text-secondary-900">{{ $course->category->name ?? '—' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Enrollment form --}}
    <section id="inscrever" class="py-20 bg-slate-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10">
                <p class="text-primary-500 font-semibold uppercase tracking-widest text-sm mb-3">Formulário de Inscrição</p>
                <h2 class="section-title">Inscreva-se em <span class="text-gradient">{{ $course->name }}</span></h2>
            </div>
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-slate-100">
                <livewire:enrollment-form :course="$course" />
            </div>
        </div>
    </section>

    {{-- Related courses --}}
    @if ($related->isNotEmpty())
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="section-title mb-8">Cursos relacionados</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($related as $rel)
                <article class="bg-white rounded-2xl overflow-hidden border border-slate-100 card-hover group">
                    <div class="h-40 bg-gradient-to-br from-secondary-800 to-secondary-900 flex items-center justify-center">
                        <i class="fa-solid fa-book-open text-white/20 text-4xl"></i>
                    </div>
                    <div class="p-5">
                        <h3 class="font-display font-bold text-secondary-900 mb-2 group-hover:text-primary-500 transition-colors">
                            <a href="{{ route('courses.show', $rel->slug) }}">{{ $rel->name }}</a>
                        </h3>
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                            <p class="font-bold text-primary-500">{{ number_format($rel->price, 0, ',', '.') }} Kz</p>
                            <a href="{{ route('courses.show', $rel->slug) }}" class="text-sm text-primary-500 font-semibold hover:underline">Ver curso →</a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-layouts.app>
