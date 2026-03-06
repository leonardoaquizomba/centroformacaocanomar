<!DOCTYPE html>
<html lang="pt" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Centro de Formação Canomar – Formação profissional e certificada em Angola' }}">
    <title>{{ isset($title) ? $title . ' | ' : '' }}Centro de Formação Canomar</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @stack('styles')

    @if (config('services.google_analytics.measurement_id'))
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.measurement_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics.measurement_id') }}');
        </script>
    @endif
</head>
<body class="bg-white text-slate-800 antialiased">

    {{-- ════════════════════════════════
         NAVBAR
    ════════════════════════════════ --}}
    <header
        x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md shadow-secondary-900/8' : 'bg-transparent'"
        class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
    >
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <div class="leading-tight">
                        <span class="block font-display font-bold text-secondary-900 text-lg leading-none">Canomar</span>
                        <span class="block text-xs text-slate-500 font-medium">Centro de Formação</span>
                    </div>
                </a>

                {{-- Desktop Menu --}}
                <ul class="hidden lg:flex items-center gap-8">
                    <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active text-primary-500' : '' }}">Início</a></li>
                    <li><a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses.*') ? 'active text-primary-500' : '' }}">Cursos</a></li>
                    <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active text-primary-500' : '' }}">Sobre Nós</a></li>
                    <li><a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active text-primary-500' : '' }}">Notícias</a></li>
                    <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active text-primary-500' : '' }}">Contacto</a></li>
                </ul>

                {{-- Desktop CTA --}}
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ url('/aluno') }}" class="text-secondary-900 font-semibold text-sm hover:text-primary-500 transition-colors">
                        <i class="bi bi-person-circle mr-1.5"></i>Portal
                    </a>
                    <a href="{{ route('courses.index') }}" class="btn-primary text-sm py-2.5 px-5">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Inscrever-me
                    </a>
                </div>

                {{-- Mobile menu button --}}
                <button @click="open = !open" class="lg:hidden p-2 rounded-xl text-secondary-900 hover:bg-slate-100 transition-colors">
                    <i x-show="!open" class="bi bi-list text-2xl"></i>
                    <i x-show="open" class="bi bi-x-lg text-2xl"></i>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="lg:hidden bg-white rounded-2xl shadow-xl border border-slate-100 mb-4 overflow-hidden"
                @click.outside="open = false"
            >
                <ul class="divide-y divide-slate-50">
                    <li><a href="{{ route('home') }}" class="flex items-center gap-3 px-5 py-4 font-medium hover:bg-slate-50 transition-colors {{ request()->routeIs('home') ? 'text-primary-500' : 'text-slate-700' }}"><i class="bi bi-house-door"></i> Início</a></li>
                    <li><a href="{{ route('courses.index') }}" class="flex items-center gap-3 px-5 py-4 font-medium hover:bg-slate-50 transition-colors {{ request()->routeIs('courses.*') ? 'text-primary-500' : 'text-slate-700' }}"><i class="bi bi-book"></i> Cursos</a></li>
                    <li><a href="{{ route('about') }}" class="flex items-center gap-3 px-5 py-4 font-medium hover:bg-slate-50 transition-colors {{ request()->routeIs('about') ? 'text-primary-500' : 'text-slate-700' }}"><i class="bi bi-info-circle"></i> Sobre Nós</a></li>
                    <li><a href="{{ route('blog.index') }}" class="flex items-center gap-3 px-5 py-4 font-medium hover:bg-slate-50 transition-colors {{ request()->routeIs('blog.*') ? 'text-primary-500' : 'text-slate-700' }}"><i class="bi bi-newspaper"></i> Notícias</a></li>
                    <li><a href="{{ route('contact') }}" class="flex items-center gap-3 px-5 py-4 font-medium hover:bg-slate-50 transition-colors {{ request()->routeIs('contact') ? 'text-primary-500' : 'text-slate-700' }}"><i class="bi bi-envelope"></i> Contacto</a></li>
                </ul>
                <div class="p-4 bg-slate-50 flex flex-col gap-3">
                    <a href="{{ url('/aluno') }}" class="btn-outline text-sm justify-center"><i class="bi bi-person-circle"></i> Aceder ao Portal</a>
                    <a href="{{ route('courses.index') }}" class="btn-primary text-sm justify-center"><i class="fa-solid fa-pen-to-square"></i> Inscrever-me</a>
                </div>
            </div>
        </nav>
    </header>

    {{-- Main Content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ════════════════════════════════
         FOOTER
    ════════════════════════════════ --}}
    <footer class="bg-secondary-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

                {{-- Brand --}}
                <div class="lg:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 bg-gradient-primary rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div>
                            <span class="block font-display font-bold text-white text-xl leading-none">Canomar</span>
                            <span class="block text-xs text-slate-400 font-medium">Centro de Formação</span>
                        </div>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Formação profissional certificada em Angola. Desenvolvemos competências e transformamos vidas através do conhecimento e da excelência.
                    </p>
                    <div class="flex items-center gap-3 mt-6">
                        <a href="#" aria-label="Facebook" class="w-9 h-9 bg-white/10 hover:bg-primary-500 rounded-lg flex items-center justify-center transition-colors duration-200">
                            <i class="bi bi-facebook text-sm"></i>
                        </a>
                        <a href="#" aria-label="Instagram" class="w-9 h-9 bg-white/10 hover:bg-primary-500 rounded-lg flex items-center justify-center transition-colors duration-200">
                            <i class="bi bi-instagram text-sm"></i>
                        </a>
                        <a href="#" aria-label="LinkedIn" class="w-9 h-9 bg-white/10 hover:bg-primary-500 rounded-lg flex items-center justify-center transition-colors duration-200">
                            <i class="bi bi-linkedin text-sm"></i>
                        </a>
                        <a href="#" aria-label="YouTube" class="w-9 h-9 bg-white/10 hover:bg-primary-500 rounded-lg flex items-center justify-center transition-colors duration-200">
                            <i class="bi bi-youtube text-sm"></i>
                        </a>
                        <a href="#" aria-label="WhatsApp" class="w-9 h-9 bg-white/10 hover:bg-primary-500 rounded-lg flex items-center justify-center transition-colors duration-200">
                            <i class="bi bi-whatsapp text-sm"></i>
                        </a>
                    </div>
                    <livewire:newsletter-form :compact="true" />
                </div>

                {{-- Links Rápidos --}}
                <div>
                    <h4 class="font-display font-semibold text-white mb-5">Links Rápidos</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="text-slate-400 hover:text-primary-400 transition-colors flex items-center gap-2"><i class="bi bi-chevron-right text-xs"></i> Início</a></li>
                        <li><a href="{{ route('courses.index') }}" class="text-slate-400 hover:text-primary-400 transition-colors flex items-center gap-2"><i class="bi bi-chevron-right text-xs"></i> Catálogo de Cursos</a></li>
                        <li><a href="{{ route('about') }}" class="text-slate-400 hover:text-primary-400 transition-colors flex items-center gap-2"><i class="bi bi-chevron-right text-xs"></i> Sobre Nós</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-slate-400 hover:text-primary-400 transition-colors flex items-center gap-2"><i class="bi bi-chevron-right text-xs"></i> Notícias & Blog</a></li>
                        <li><a href="{{ route('certificate.verify') }}" class="text-slate-400 hover:text-primary-400 transition-colors flex items-center gap-2"><i class="bi bi-chevron-right text-xs"></i> Verificar Certificado</a></li>
                        <li><a href="{{ route('contact') }}" class="text-slate-400 hover:text-primary-400 transition-colors flex items-center gap-2"><i class="bi bi-chevron-right text-xs"></i> Contacto</a></li>
                    </ul>
                </div>

                {{-- Contacto --}}
                <div>
                    <h4 class="font-display font-semibold text-white mb-5">Contacte-nos</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3 text-slate-400">
                            <i class="fa-solid fa-location-dot text-primary-400 mt-0.5"></i>
                            <span>Rua Principal, nº 123<br>Luanda, Angola</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-400">
                            <i class="fa-solid fa-phone text-primary-400"></i>
                            <a href="tel:+244900000000" class="hover:text-primary-400 transition-colors">+244 900 000 000</a>
                        </li>
                        <li class="flex items-center gap-3 text-slate-400">
                            <i class="fa-solid fa-envelope text-primary-400"></i>
                            <a href="mailto:geral@canomar.ao" class="hover:text-primary-400 transition-colors">geral@canomar.ao</a>
                        </li>
                        <li class="flex items-center gap-3 text-slate-400">
                            <i class="fa-brands fa-whatsapp text-primary-400"></i>
                            <a href="https://wa.me/244900000000" class="hover:text-primary-400 transition-colors">WhatsApp</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="border-t border-white/10 mt-12 pt-7 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Centro de Formação Canomar. Todos os direitos reservados.</p>
                <div class="flex items-center gap-5">
                    <a href="#" class="hover:text-primary-400 transition-colors">Política de Privacidade</a>
                    <a href="#" class="hover:text-primary-400 transition-colors">Termos de Uso</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')

    {{-- Scroll-to-top button --}}
    <div x-data="{ show: false }" x-init="window.addEventListener('scroll', () => show = window.scrollY > 400)">
        <button
            x-show="show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-6 right-6 z-50 w-11 h-11 bg-primary-500 hover:bg-primary-600 text-white rounded-xl shadow-lg shadow-primary-500/40 flex items-center justify-center transition-colors duration-200"
            aria-label="Voltar ao topo"
        >
            <i class="bi bi-chevron-up font-bold"></i>
        </button>
    </div>
</body>
</html>
