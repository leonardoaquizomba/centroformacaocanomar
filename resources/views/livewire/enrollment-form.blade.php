<div>
    @if ($submitted)
        {{-- ── Success ────────────────────────────────────────────────────── --}}
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

    @elseif ($authMode === 'prompt')
        {{-- ── Auth gate: not logged in ────────────────────────────────────── --}}
        <div class="text-center py-6">
            <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <i class="fa-solid fa-lock text-primary-500 text-2xl"></i>
            </div>
            <h3 class="font-display font-bold text-secondary-900 text-xl mb-2">Acesso necessário</h3>
            <p class="text-slate-500 text-sm mb-8 max-w-sm mx-auto">
                Para se inscrever no curso <strong>{{ $course->name }}</strong> precisa de ter uma conta.
                Inicie sessão ou crie uma conta gratuita.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button wire:click="showLogin" class="btn-primary px-8">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sessão
                </button>
                <button wire:click="showRegister" class="btn-outline px-8">
                    <i class="bi bi-person-plus"></i> Criar Conta
                </button>
            </div>
        </div>

    @elseif ($authMode === 'login')
        {{-- ── Inline Login ────────────────────────────────────────────────── --}}
        <div>
            <div class="flex items-center gap-3 mb-6">
                <button wire:click="$set('authMode', 'prompt')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-arrow-left text-lg"></i>
                </button>
                <h3 class="font-display font-bold text-secondary-900 text-xl">Iniciar Sessão</h3>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Email *</label>
                    <input wire:model="authEmail" type="email" placeholder="email@exemplo.com"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('authEmail') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('authEmail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Palavra-passe *</label>
                    <input wire:model="authPassword" type="password" placeholder="••••••••"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('authPassword') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('authPassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button wire:click="login" wire:loading.attr="disabled" class="btn-primary w-full justify-center">
                    <span wire:loading.remove wire:target="login"><i class="bi bi-box-arrow-in-right"></i> Entrar</span>
                    <span wire:loading wire:target="login"><i class="fa-solid fa-circle-notch fa-spin"></i> A entrar…</span>
                </button>

                <p class="text-center text-sm text-slate-500">
                    Não tem conta?
                    <button wire:click="showRegister" class="text-primary-500 font-semibold hover:underline">Criar conta</button>
                </p>
            </div>
        </div>

    @elseif ($authMode === 'register')
        {{-- ── Inline Registration ─────────────────────────────────────────── --}}
        <div>
            <div class="flex items-center gap-3 mb-6">
                <button wire:click="$set('authMode', 'prompt')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-arrow-left text-lg"></i>
                </button>
                <h3 class="font-display font-bold text-secondary-900 text-xl">Criar Conta</h3>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Nome completo *</label>
                    <input wire:model="registerName" type="text" placeholder="O seu nome completo"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('registerName') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('registerName') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Email *</label>
                    <input wire:model="registerEmail" type="email" placeholder="email@exemplo.com"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('registerEmail') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('registerEmail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Palavra-passe *</label>
                        <input wire:model="registerPassword" type="password" placeholder="Mín. 8 caracteres"
                               class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('registerPassword') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                        @error('registerPassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Confirmar palavra-passe *</label>
                        <input wire:model="registerPasswordConfirmation" type="password" placeholder="Repita a palavra-passe"
                               class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition border-slate-200">
                    </div>
                </div>

                <p class="text-xs text-slate-400">
                    <i class="bi bi-shield-check text-primary-400 mr-1"></i>
                    Os seus dados são protegidos e não serão partilhados com terceiros.
                </p>

                <button wire:click="register" wire:loading.attr="disabled" class="btn-primary w-full justify-center">
                    <span wire:loading.remove wire:target="register"><i class="bi bi-person-check"></i> Criar Conta e Continuar</span>
                    <span wire:loading wire:target="register"><i class="fa-solid fa-circle-notch fa-spin"></i> A criar conta…</span>
                </button>

                <p class="text-center text-sm text-slate-500">
                    Já tem conta?
                    <button wire:click="showLogin" class="text-primary-500 font-semibold hover:underline">Iniciar sessão</button>
                </p>
            </div>
        </div>

    @else
        {{-- ── Multi-step enrollment form ──────────────────────────────────── --}}

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
                @foreach (['Dados Pessoais', 'Documentos', 'Turma', 'Confirmação'] as $i => $label)
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

        {{-- Step 1: Personal Info ──────────────────────────────────────────── --}}
        @if ($step === 1)
        <div class="space-y-5">
            <h3 class="font-display font-bold text-secondary-900 text-xl mb-6">Dados Pessoais</h3>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Nome completo *</label>
                    <input wire:model="name" type="text" placeholder="O seu nome completo"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Bilhete de Identidade / Passaporte *</label>
                    <input wire:model="bi" type="text" placeholder="000000000LA000"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('bi') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('bi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Email *</label>
                    <input wire:model="email" type="email" placeholder="email@exemplo.com"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-secondary-900 mb-1.5">Telefone *</label>
                    <input wire:model="phone" type="tel" placeholder="+244 900 000 000"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep" class="btn-primary">
                    <span wire:loading.remove wire:target="nextStep">Próximo <i class="bi bi-arrow-right"></i></span>
                    <span wire:loading wire:target="nextStep"><i class="fa-solid fa-circle-notch fa-spin"></i></span>
                </button>
            </div>
        </div>
        @endif

        {{-- Step 2: Documents ────────────────────────────────────────────────── --}}
        @if ($step === 2)
        <div class="space-y-6">
            <div>
                <h3 class="font-display font-bold text-secondary-900 text-xl">Documentos</h3>
                <p class="text-slate-500 text-sm mt-1">Carregue os seus documentos. Todos os campos são opcionais mas recomendados.</p>
            </div>

            {{-- BI / Passport --}}
            <div>
                <label class="block text-sm font-semibold text-secondary-900 mb-1.5">
                    <i class="bi bi-person-vcard text-primary-400 mr-1"></i>
                    Bilhete de Identidade / Passaporte *
                </label>
                <label class="flex items-center gap-4 p-4 rounded-xl border-2 border-dashed cursor-pointer transition-all
                    {{ $biDocument ? 'border-green-400 bg-green-50' : 'border-slate-200 hover:border-primary-300 hover:bg-primary-50/40' }} {{ $errors->has('biDocument') ? 'border-red-400 bg-red-50' : '' }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                        {{ $biDocument ? 'bg-green-100' : 'bg-slate-100' }}">
                        <i class="fa-solid {{ $biDocument ? 'fa-check text-green-500' : 'fa-upload text-slate-400' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        @if ($biDocument)
                            <p class="text-sm font-medium text-green-700 truncate">{{ $biDocument->getClientOriginalName() }}</p>
                            <p class="text-xs text-green-500">{{ number_format($biDocument->getSize() / 1024, 1) }} KB</p>
                        @else
                            <p class="text-sm font-medium text-slate-600">Clique para seleccionar ficheiro</p>
                            <p class="text-xs text-slate-400">PDF, JPG ou PNG · máx. 5 MB</p>
                        @endif
                    </div>
                    <input type="file" wire:model="biDocument" accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                </label>
                @error('biDocument') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Payment proof --}}
            <div>
                <label class="block text-sm font-semibold text-secondary-900 mb-1.5">
                    <i class="bi bi-receipt text-primary-400 mr-1"></i>
                    Comprovativo de Pagamento *
                </label>
                <label class="flex items-center gap-4 p-4 rounded-xl border-2 border-dashed cursor-pointer transition-all
                    {{ $paymentProof ? 'border-green-400 bg-green-50' : 'border-slate-200 hover:border-primary-300 hover:bg-primary-50/40' }} {{ $errors->has('paymentProof') ? 'border-red-400 bg-red-50' : '' }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                        {{ $paymentProof ? 'bg-green-100' : 'bg-slate-100' }}">
                        <i class="fa-solid {{ $paymentProof ? 'fa-check text-green-500' : 'fa-upload text-slate-400' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        @if ($paymentProof)
                            <p class="text-sm font-medium text-green-700 truncate">{{ $paymentProof->getClientOriginalName() }}</p>
                            <p class="text-xs text-green-500">{{ number_format($paymentProof->getSize() / 1024, 1) }} KB</p>
                        @else
                            <p class="text-sm font-medium text-slate-600">Clique para seleccionar ficheiro</p>
                            <p class="text-xs text-slate-400">PDF, JPG ou PNG · máx. 5 MB</p>
                        @endif
                    </div>
                    <input type="file" wire:model="paymentProof" accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                </label>
                @error('paymentProof') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Other documents --}}
            <div>
                <label class="block text-sm font-semibold text-secondary-900 mb-1.5">
                    <i class="bi bi-folder2-open text-primary-400 mr-1"></i>
                    Outros Documentos
                    <span class="font-normal text-slate-400 ml-1">(pode seleccionar vários)</span>
                </label>
                <label class="flex items-center gap-4 p-4 rounded-xl border-2 border-dashed cursor-pointer transition-all
                    {{ count($otherDocuments) ? 'border-green-400 bg-green-50' : 'border-slate-200 hover:border-primary-300 hover:bg-primary-50/40' }} {{ $errors->has('otherDocuments.*') ? 'border-red-400 bg-red-50' : '' }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                        {{ count($otherDocuments) ? 'bg-green-100' : 'bg-slate-100' }}">
                        <i class="fa-solid {{ count($otherDocuments) ? 'fa-check text-green-500' : 'fa-upload text-slate-400' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        @if (count($otherDocuments))
                            <p class="text-sm font-medium text-green-700">{{ count($otherDocuments) }} ficheiro(s) seleccionado(s)</p>
                            <p class="text-xs text-green-500">
                                @foreach ($otherDocuments as $doc) {{ $doc->getClientOriginalName() }}@if(!$loop->last), @endif @endforeach
                            </p>
                        @else
                            <p class="text-sm font-medium text-slate-600">Clique para seleccionar ficheiros</p>
                            <p class="text-xs text-slate-400">PDF, JPG, PNG, DOC, DOCX · máx. 10 MB cada</p>
                        @endif
                    </div>
                    <input type="file" wire:model="otherDocuments" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple class="hidden">
                </label>
                @error('otherDocuments.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between pt-2">
                <button wire:click="prevStep" class="btn-outline">
                    <i class="bi bi-arrow-left"></i> Anterior
                </button>
                <button wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep" class="btn-primary">
                    <span wire:loading.remove wire:target="nextStep">Próximo <i class="bi bi-arrow-right"></i></span>
                    <span wire:loading wire:target="nextStep"><i class="fa-solid fa-circle-notch fa-spin"></i> A processar…</span>
                </button>
            </div>
        </div>
        @endif

        {{-- Step 3: Class selection ──────────────────────────────────────────── --}}
        @if ($step === 3)
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
                    <label class="flex items-start gap-4 p-4 rounded-xl border cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all
                        {{ $courseClassId == $class->id ? 'border-primary-500 bg-primary-50' : 'border-slate-200' }}">
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

        {{-- Step 4: Confirmation ──────────────────────────────────────────────── --}}
        @if ($step === 4)
        <div>
            <h3 class="font-display font-bold text-secondary-900 text-xl mb-6">Confirme os seus dados</h3>

            <div class="bg-slate-50 rounded-2xl p-6 space-y-4 mb-8">
                {{-- Personal info --}}
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><p class="text-slate-400">Nome</p><p class="font-semibold text-secondary-900">{{ $name }}</p></div>
                    <div><p class="text-slate-400">Email</p><p class="font-semibold text-secondary-900">{{ $email }}</p></div>
                    <div><p class="text-slate-400">Telefone</p><p class="font-semibold text-secondary-900">{{ $phone }}</p></div>
                    @if ($bi) <div><p class="text-slate-400">BI / Passaporte</p><p class="font-semibold text-secondary-900">{{ $bi }}</p></div> @endif
                </div>

                <hr class="border-slate-200">

                {{-- Course --}}
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

                {{-- Documents summary --}}
                @if ($biDocument || $paymentProof || count($otherDocuments))
                <hr class="border-slate-200">
                <div class="text-sm">
                    <p class="text-slate-400 mb-2">Documentos anexados</p>
                    <ul class="space-y-1">
                        @if ($biDocument)
                        <li class="flex items-center gap-2 text-slate-700">
                            <i class="bi bi-file-earmark-check text-green-500"></i>
                            <span>BI/Passaporte: {{ $biDocument->getClientOriginalName() }}</span>
                        </li>
                        @endif
                        @if ($paymentProof)
                        <li class="flex items-center gap-2 text-slate-700">
                            <i class="bi bi-file-earmark-check text-green-500"></i>
                            <span>Comprovativo: {{ $paymentProof->getClientOriginalName() }}</span>
                        </li>
                        @endif
                        @foreach ($otherDocuments as $doc)
                        <li class="flex items-center gap-2 text-slate-700">
                            <i class="bi bi-file-earmark-check text-green-500"></i>
                            <span>Outro: {{ $doc->getClientOriginalName() }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <div class="flex justify-between">
                <button wire:click="prevStep" class="btn-outline">
                    <i class="bi bi-arrow-left"></i> Anterior
                </button>
                <button wire:click="submit" class="btn-primary px-8" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit"><i class="fa-solid fa-check"></i> Confirmar Inscrição</span>
                    <span wire:loading wire:target="submit"><i class="fa-solid fa-circle-notch fa-spin"></i> A processar…</span>
                </button>
            </div>
        </div>
        @endif
    @endif
</div>
