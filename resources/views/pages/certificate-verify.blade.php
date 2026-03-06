<x-layouts.app>
    <x-slot name="title">Verificar Certificado</x-slot>

    <section class="bg-gradient-hero pt-36 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image:linear-gradient(rgba(255,255,255,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            <p class="text-primary-400 font-semibold uppercase tracking-widest text-sm mb-4">Autenticidade</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-5">Verificar Certificado</h1>
            <p class="text-slate-300 text-lg max-w-xl mx-auto">Confirme a autenticidade de um certificado emitido pelo Centro de Formação Canomar.</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 60" fill="white" preserveAspectRatio="none" class="w-full h-10"><path d="M0,60 C480,0 960,0 1440,60 L1440,60 L0,60 Z"/></svg></div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">

            {{-- Verify form --}}
            <div class="bg-slate-50 rounded-3xl p-10 border border-slate-100 shadow-sm mb-10"
                 x-data="{
                     code: '',
                     loading: false,
                     result: null,
                     error: false,
                     async verify() {
                         if (!this.code.trim()) return;
                         this.loading = true; this.result = null; this.error = false;
                         try {
                             const res = await fetch('{{ route('certificate.verify.check') }}', {
                                 method: 'POST',
                                 headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                 body: JSON.stringify({ code: this.code })
                             });
                             this.result = await res.json();
                         } catch(e) { this.error = true; }
                         finally { this.loading = false; }
                     }
                 }">

                <div class="flex items-center justify-center mb-8">
                    <div class="w-16 h-16 bg-primary-50 rounded-2xl flex items-center justify-center">
                        <i class="fa-solid fa-certificate text-primary-500 text-3xl"></i>
                    </div>
                </div>

                <h2 class="font-display font-bold text-secondary-900 text-2xl text-center mb-2">Introduza o código do certificado</h2>
                <p class="text-slate-400 text-center text-sm mb-8">O código encontra-se no certificado no formato <strong>CAN-YYYY-NNNNNN</strong></p>

                <div class="flex gap-3">
                    <input
                        x-model="code"
                        @keydown.enter="verify()"
                        type="text"
                        placeholder="Ex: CAN-2025-000001"
                        class="flex-1 px-5 py-4 rounded-xl border border-slate-200 text-center font-mono font-semibold text-secondary-900 tracking-widest text-lg focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition uppercase"
                        style="text-transform:uppercase"
                    >
                    <button @click="verify()" :disabled="loading || !code.trim()"
                            class="btn-primary px-6 py-4 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!loading"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <span x-show="loading"><i class="fa-solid fa-circle-notch fa-spin"></i></span>
                    </button>
                </div>

                {{-- Error state --}}
                <div x-show="error" class="mt-6 bg-red-50 border border-red-200 rounded-2xl p-5 text-center">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-2xl mb-2"></i>
                    <p class="text-red-700 font-medium">Ocorreu um erro. Por favor tente novamente.</p>
                </div>

                {{-- Not found --}}
                <div x-show="result && !result.found" class="mt-6 bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 text-3xl mb-3"></i>
                    <p class="font-display font-bold text-amber-800 text-lg mb-1">Certificado não encontrado</p>
                    <p class="text-amber-600 text-sm">O código introduzido não corresponde a nenhum certificado válido nos nossos registos.</p>
                </div>

                {{-- Found --}}
                <div x-show="result && result.found" class="mt-6 bg-green-50 border border-green-200 rounded-2xl p-7">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-check text-green-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-display font-bold text-green-800 text-lg">Certificado Válido</p>
                            <p class="text-green-600 text-sm">Este certificado é autêntico e foi emitido pelo Centro Canomar.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm border-t border-green-200 pt-5">
                        <div><p class="text-green-600">Código</p><p class="font-mono font-bold text-secondary-900" x-text="result?.code"></p></div>
                        <div><p class="text-green-600">Emitido em</p><p class="font-semibold text-secondary-900" x-text="result?.issued_at"></p></div>
                        <div><p class="text-green-600">Aluno</p><p class="font-semibold text-secondary-900" x-text="result?.student"></p></div>
                        <div><p class="text-green-600">Curso</p><p class="font-semibold text-secondary-900" x-text="result?.course"></p></div>
                    </div>
                </div>
            </div>

            <div class="text-center text-sm text-slate-400">
                <i class="bi bi-shield-lock text-primary-400 mr-2"></i>
                Verificação segura. Os seus dados não são armazenados nesta pesquisa.
            </div>
        </div>
    </section>
</x-layouts.app>
