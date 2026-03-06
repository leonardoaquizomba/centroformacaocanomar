<x-layouts.app>
    <x-slot name="title">Catálogo de Cursos</x-slot>

    {{-- Page header --}}
    <section class="bg-gradient-hero pt-36 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image:linear-gradient(rgba(255,255,255,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            <p class="text-primary-400 font-semibold uppercase tracking-widest text-sm mb-4">Formação Profissional</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">Catálogo de Cursos</h1>
            <p class="text-slate-300 text-lg max-w-xl mx-auto">
                Encontre a formação ideal para si. Cursos certificados nas mais diversas áreas.
            </p>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 60" fill="white" preserveAspectRatio="none" class="w-full h-10"><path d="M0,60 C480,0 960,0 1440,60 L1440,60 L0,60 Z"/></svg>
        </div>
    </section>

    <section class="py-14 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:course-catalog />
        </div>
    </section>
</x-layouts.app>
