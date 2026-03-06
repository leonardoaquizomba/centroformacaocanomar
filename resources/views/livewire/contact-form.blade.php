<div>
    @if ($sent)
        <div class="bg-green-50 border border-green-200 rounded-2xl p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check text-green-500 text-2xl"></i>
            </div>
            <h3 class="font-display font-bold text-secondary-900 text-xl mb-2">Mensagem enviada!</h3>
            <p class="text-slate-500">Recebemos a sua mensagem e entraremos em contacto em breve.</p>
            <button wire:click="$set('sent', false)" class="btn-primary mt-6 text-sm">
                Enviar outra mensagem
            </button>
        </div>
    @else
        <form wire:submit="send" class="space-y-5">
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Nome completo *</label>
                    <input wire:model="name" type="text" placeholder="O seu nome"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Email *</label>
                    <input wire:model="email" type="email" placeholder="email@exemplo.com"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Telefone</label>
                <input wire:model="phone" type="tel" placeholder="+244 900 000 000"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Mensagem *</label>
                <textarea wire:model="message" rows="5" placeholder="Escreva a sua mensagem…"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition resize-none @error('message') border-red-400 @enderror"></textarea>
                @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3.5" wire:loading.attr="disabled">
                <span wire:loading.remove><i class="fa-solid fa-paper-plane"></i> Enviar Mensagem</span>
                <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> A enviar…</span>
            </button>
        </form>
    @endif
</div>
