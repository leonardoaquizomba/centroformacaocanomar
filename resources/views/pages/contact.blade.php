<x-layouts.app>
    <x-slot name="title">Contacto</x-slot>

    <section class="bg-gradient-hero pt-36 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image:linear-gradient(rgba(255,255,255,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            <p class="text-primary-400 font-semibold uppercase tracking-widest text-sm mb-4">Fale Connosco</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-5">Entre em Contacto</h1>
            <p class="text-slate-300 text-lg max-w-xl mx-auto">Estamos aqui para ajudar. Envie-nos uma mensagem ou visite-nos pessoalmente.</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 60" fill="white" preserveAspectRatio="none" class="w-full h-10"><path d="M0,60 C480,0 960,0 1440,60 L1440,60 L0,60 Z"/></svg></div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-5 gap-12">

                {{-- Contact info --}}
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="font-display font-bold text-secondary-900 text-2xl mb-8">Informações de Contacto</h2>

                    @foreach ([
                        ['icon'=>'fa-location-dot','title'=>'Morada','lines'=>['Rua Principal, nº 123','Luanda, Angola']],
                        ['icon'=>'fa-phone','title'=>'Telefone','lines',['+244 900 000 000','Segunda a Sexta, 8h–17h']],
                        ['icon'=>'fa-envelope','title'=>'Email','lines'=>['geral@canomar.ao','suporte@canomar.ao']],
                        ['icon'=>'fa-brands fa-whatsapp','title'=>'WhatsApp','lines'=>['+244 900 000 000','Resposta rápida']],
                    ] as $info)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                            <i class="{{ str_starts_with($info['icon'], 'fa-brands') ? '' : 'fa-solid' }} {{ $info['icon'] }} text-primary-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-secondary-900 mb-1">{{ $info['title'] }}</p>
                            @foreach ($info['lines'] ?? [] as $line)
                            <p class="text-slate-500 text-sm">{{ $line }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    {{-- Social links --}}
                    <div class="pt-6 border-t border-slate-100">
                        <p class="font-semibold text-secondary-900 mb-4">Redes Sociais</p>
                        <div class="flex gap-3">
                            @foreach ([['bi-facebook','Facebook'],['bi-instagram','Instagram'],['bi-linkedin','LinkedIn'],['bi-youtube','YouTube']] as [$icon, $label])
                            <a href="#" aria-label="{{ $label }}"
                               class="w-10 h-10 bg-slate-100 hover:bg-primary-500 hover:text-white rounded-xl flex items-center justify-center text-slate-500 transition-all duration-200">
                                <i class="bi {{ $icon }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Contact form --}}
                <div class="lg:col-span-3">
                    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100">
                        <h2 class="font-display font-bold text-secondary-900 text-2xl mb-7">Envie-nos uma mensagem</h2>
                        <livewire:contact-form />
                    </div>
                </div>
            </div>

            {{-- Map placeholder --}}
            <div class="mt-16 rounded-3xl overflow-hidden border border-slate-100 h-72 bg-slate-100 flex items-center justify-center">
                <div class="text-center text-slate-400">
                    <i class="fa-solid fa-map-location-dot text-5xl mb-3 text-primary-300"></i>
                    <p class="font-medium">Mapa de localização</p>
                    <p class="text-sm">Rua Principal, nº 123, Luanda, Angola</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
