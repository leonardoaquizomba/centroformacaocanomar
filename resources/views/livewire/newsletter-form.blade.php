<div>
    @if ($subscribed)
        {{-- Success state --}}
        @if ($compact)
            <div class="flex items-center gap-3 text-white">
                <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check text-sm"></i>
                </div>
                <p class="text-sm font-medium">Obrigado! Está subscrito à nossa newsletter.</p>
            </div>
        @else
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-500/20 border border-primary-500/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-check text-primary-400 text-2xl"></i>
                </div>
                <h3 class="font-display font-bold text-white text-xl mb-2">Subscrição confirmada!</h3>
                <p class="text-slate-300 text-sm">Obrigado por subscrever. Irá receber as nossas novidades em breve.</p>
            </div>
        @endif
    @else
        {{-- Compact footer form --}}
        @if ($compact)
            <form wire:submit="subscribe" class="mt-5">
                <p class="text-slate-300 text-sm mb-3 font-medium">Receba as nossas novidades</p>
                <div class="flex gap-2">
                    <input
                        wire:model="email"
                        type="email"
                        placeholder="O seu e-mail"
                        class="flex-1 min-w-0 px-3 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/40 focus:border-primary-400 transition @error('email') border-red-400 @enderror"
                    >
                    <button
                        type="submit"
                        class="px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-semibold rounded-xl transition-colors duration-200 shrink-0"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove><i class="bi bi-send"></i></span>
                        <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i></span>
                    </button>
                </div>
                @error('email') <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p> @enderror
            </form>
        @else
            {{-- Full homepage form --}}
            <form wire:submit="subscribe" class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
                <input
                    wire:model="name"
                    type="text"
                    placeholder="O seu nome (opcional)"
                    class="flex-1 px-5 py-4 rounded-xl bg-white/10 border border-white/20 text-white text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/40 focus:border-primary-400 transition"
                >
                <input
                    wire:model="email"
                    type="email"
                    placeholder="O seu e-mail"
                    class="flex-1 px-5 py-4 rounded-xl bg-white/10 border border-white/20 text-white text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/40 focus:border-primary-400 transition @error('email') border-red-400 @enderror"
                >
                <button
                    type="submit"
                    class="px-7 py-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl transition-colors duration-200 shrink-0 flex items-center gap-2 justify-center"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove><i class="bi bi-send"></i> Subscrever</span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> A processar…</span>
                </button>
            </form>
            @error('email')
                <p class="text-red-400 text-sm mt-3 text-center">{{ $message }}</p>
            @enderror
        @endif
    @endif
</div>
