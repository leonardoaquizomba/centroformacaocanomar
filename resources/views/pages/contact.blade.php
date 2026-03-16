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

                    @if ($siteSettings->address)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot text-primary-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-secondary-900 mb-1">Morada</p>
                            <p class="text-slate-500 text-sm">{{ $siteSettings->address }}</p>
                        </div>
                    </div>
                    @endif

                    @if ($siteSettings->phone)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone text-primary-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-secondary-900 mb-1">Telefone</p>
                            <p class="text-slate-500 text-sm">
                                <a href="{{ $siteSettings->telLink() }}" class="hover:text-primary-500 transition-colors">{{ $siteSettings->phone }}</a>
                            </p>
                            <p class="text-slate-400 text-xs mt-0.5">Segunda a Sexta, 8h–17h</p>
                        </div>
                    </div>
                    @endif

                    @if ($siteSettings->email)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-envelope text-primary-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-secondary-900 mb-1">Email</p>
                            <p class="text-slate-500 text-sm">
                                <a href="mailto:{{ $siteSettings->email }}" class="hover:text-primary-500 transition-colors">{{ $siteSettings->email }}</a>
                            </p>
                            @if ($siteSettings->support_email)
                            <p class="text-slate-500 text-sm">
                                <a href="mailto:{{ $siteSettings->support_email }}" class="hover:text-primary-500 transition-colors">{{ $siteSettings->support_email }}</a>
                            </p>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if ($siteSettings->whatsapp)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-whatsapp text-primary-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-secondary-900 mb-1">WhatsApp</p>
                            <p class="text-slate-500 text-sm">
                                <a href="{{ $siteSettings->whatsappUrl() }}" target="_blank" rel="noopener" class="hover:text-primary-500 transition-colors">{{ $siteSettings->phone ?? $siteSettings->whatsapp }}</a>
                            </p>
                            <p class="text-slate-400 text-xs mt-0.5">Resposta rápida</p>
                        </div>
                    </div>
                    @endif

                    {{-- Social links --}}
                    @php
                        $socials = array_filter([
                            ['url' => $siteSettings->facebook_url,  'icon' => 'bi-facebook',  'label' => 'Facebook'],
                            ['url' => $siteSettings->instagram_url, 'icon' => 'bi-instagram', 'label' => 'Instagram'],
                            ['url' => $siteSettings->linkedin_url,  'icon' => 'bi-linkedin',  'label' => 'LinkedIn'],
                            ['url' => $siteSettings->youtube_url,   'icon' => 'bi-youtube',   'label' => 'YouTube'],
                            ['url' => $siteSettings->tiktok_url,    'icon' => 'bi-tiktok',    'label' => 'TikTok'],
                        ], fn ($s) => ! empty($s['url']));
                    @endphp

                    @if (count($socials))
                    <div class="pt-6 border-t border-slate-100">
                        <p class="font-semibold text-secondary-900 mb-4">Redes Sociais</p>
                        <div class="flex gap-3">
                            @foreach ($socials as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }}"
                               class="w-10 h-10 bg-slate-100 hover:bg-primary-500 hover:text-white rounded-xl flex items-center justify-center text-slate-500 transition-all duration-200">
                                <i class="bi {{ $social['icon'] }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
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
                    @if ($siteSettings->address)
                    <p class="text-sm">{{ $siteSettings->address }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
