<div>
    @if ($submitted)
        {{-- Success --}}
        <div class="text-center py-10">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-check text-green-500 text-3xl"></i>
            </div>
            <h3 class="font-display font-bold text-secondary-900 text-2xl mb-3">Inscrição submetida!</h3>
            <p class="text-slate-500 max-w-md mx-auto">
                A sua inscrição no curso <strong>{{ $course->name }}</strong> foi recebida com sucesso.
                Entraremos em contacto em breve para confirmar os detalhes.
            </p>
            <a href="{{ route('courses.index') }}" class="btn-primary mt-8">
                <i class="bi bi-arrow-left"></i> Ver outros cursos
            </a>
        </div>
    @else
        {{-- Progress bar --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-secondary-900">Passo {{ $step }} de {{ $totalSteps }}</span>
                <span class="text-sm text-slate-400">{{ round(($step / $totalSteps) * 100) }}% concluído</span>
            </div>
            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-primary rounded-full transition-all duration-500"
                     style="width: {{ ($step / $totalSteps) * 100 }}%"></div>
            </div>
            <div class="flex justify-between mt-3">
                @foreach (['Dados Pessoais', 'Turma', 'Confirmação'] as $i => $label)
                <div class="flex flex-col items-center gap-1">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all
                        {{ $step > $i + 1 ? 'bg-green-500 text-white' : ($step == $i + 1 ? 'bg-primary-500 text-white' : 'bg-slate-100 text-slate-400') }}">
                        {{ $step > $i + 1 ? '✓' : $i + 1 }}
                    </div>
                    <span class="text-xs hidden sm:block {{ $step == $i + 1 ? 'text-primary-500 font-semibold' : 'text-slate-400' }}">{{ $label }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Step 1: Personal Info --}}
        @if ($step === 1)
        <div class="space-y-5">
            <h3 class="font-display font-bold text-secondary-900 text-xl mb-6">Dados Pessoais</h3>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Nome completo *</label>
                    <input wire:model="name" type="text" placeholder="O seu nome completo"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Bilhete de Identidade</label>
                    <input wire:model="bi" type="text" placeholder="000000000LA000"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Email *</label>
                    <input wire:model="email" type="email" placeholder="email@exemplo.com"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Telefone *</label>
                    <input wire:model="phone" type="tel" placeholder="+244 900 000 000"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition @error('phone') border-red-400 @enderror">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button wire:click="nextStep" class="btn-primary">
                    Próximo <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
        @endif

        {{-- Step 2: Class selection --}}
        @if ($step === 2)
        <div class="space-y-5">
            <h3 class="font-display font-bold text-secondary-900 text-xl mb-6">Escolha a Turma</h3>

            @if ($this->availableClasses->isEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 text-amber-700 text-sm">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                    Não há turmas disponíveis de momento. A sua inscrição ficará registada e será contactado quando abrirem novas turmas.
                </div>
            @else
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Seleccione uma turma (opcional)</label>
                    @foreach ($this->availableClasses as $class)
                    <label class="flex items-start gap-4 p-4 rounded-xl border border-slate-200 cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all
                        {{ $courseClassId == $class->id ? 'border-primary-500 bg-primary-50' : '' }}">
                        <input type="radio" wire:model="courseClassId" value="{{ $class->id }}" class="mt-1 accent-primary-500">
                        <div>
                            <p class="font-semibold text-secondary-900">{{ $class->name }}</p>
                            <p class="text-xs text-slate-400 mt-1">
                                <i class="bi bi-calendar3 mr-1"></i>
                                {{ $class->start_date?->format('d/m/Y') }} – {{ $class->end_date?->format('d/m/Y') }}
                                &nbsp;|&nbsp;
                                <i class="bi bi-people mr-1"></i>{{ $class->max_students }} vagas
                            </p>
                        </div>
                    </label>
                    @endforeach
                </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Observações</label>
                <textarea wire:model="notes" rows="3" placeholder="Alguma informação adicional…"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition resize-none"></textarea>
            </div>

            <div class="flex justify-between pt-4">
                <button wire:click="prevStep" class="btn-outline">
                    <i class="bi bi-arrow-left"></i> Anterior
                </button>
                <button wire:click="nextStep" class="btn-primary">
                    Próximo <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
        @endif

        {{-- Step 3: Confirmation --}}
        @if ($step === 3)
        <div>
            <h3 class="font-display font-bold text-secondary-900 text-xl mb-6">Confirme os seus dados</h3>

            <div class="bg-slate-50 rounded-2xl p-6 space-y-4 mb-8">
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><p class="text-slate-400">Nome</p><p class="font-semibold text-secondary-900">{{ $name }}</p></div>
                    <div><p class="text-slate-400">Email</p><p class="font-semibold text-secondary-900">{{ $email }}</p></div>
                    <div><p class="text-slate-400">Telefone</p><p class="font-semibold text-secondary-900">{{ $phone }}</p></div>
                    @if ($bi) <div><p class="text-slate-400">BI</p><p class="font-semibold text-secondary-900">{{ $bi }}</p></div> @endif
                </div>
                <hr class="border-slate-200">
                <div class="text-sm">
                    <p class="text-slate-400">Curso</p>
                    <p class="font-semibold text-secondary-900">{{ $course->name }}</p>
                </div>
                @if ($courseClassId)
                <div class="text-sm">
                    <p class="text-slate-400">Turma</p>
                    <p class="font-semibold text-secondary-900">{{ $this->availableClasses->firstWhere('id', $courseClassId)?->name }}</p>
                </div>
                @endif
            </div>

            <div class="flex justify-between">
                <button wire:click="prevStep" class="btn-outline">
                    <i class="bi bi-arrow-left"></i> Anterior
                </button>
                <button wire:click="submit" class="btn-primary px-8" wire:loading.attr="disabled">
                    <span wire:loading.remove><i class="fa-solid fa-check"></i> Confirmar Inscrição</span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> A processar…</span>
                </button>
            </div>
        </div>
        @endif
    @endif
</div>
