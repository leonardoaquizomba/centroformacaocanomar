<div>
    {{-- Filters bar --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-5 mb-8 shadow-sm">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Search --}}
            <div class="relative lg:col-span-1">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Pesquisar cursos…"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition"
                >
            </div>

            {{-- Category --}}
            <select wire:model.live="category"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition bg-white">
                <option value="">Todas as Categorias</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}">{{ $cat->name }} ({{ $cat->courses_count }})</option>
                @endforeach
            </select>

            {{-- Modality --}}
            <select wire:model.live="modality"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition bg-white">
                <option value="">Todas as Modalidades</option>
                <option value="presencial">Presencial</option>
                <option value="online">Online</option>
                <option value="misto">Misto</option>
            </select>

            {{-- Level --}}
            <select wire:model.live="level"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-400 transition bg-white">
                <option value="">Todos os Níveis</option>
                <option value="básico">Básico</option>
                <option value="médio">Médio</option>
                <option value="avançado">Avançado</option>
            </select>
        </div>

        {{-- Active filters --}}
        @if ($search || $category || $modality || $level)
        <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-slate-100">
            <span class="text-xs text-slate-500 self-center mr-1">Filtros activos:</span>
            @if ($search)
                <span class="inline-flex items-center gap-1.5 bg-primary-50 text-primary-600 text-xs font-medium px-3 py-1 rounded-full">
                    "{{ $search }}"
                    <button wire:click="$set('search', '')" class="hover:text-primary-800"><i class="bi bi-x"></i></button>
                </span>
            @endif
            @if ($category)
                <span class="inline-flex items-center gap-1.5 bg-primary-50 text-primary-600 text-xs font-medium px-3 py-1 rounded-full">
                    {{ $categories->firstWhere('slug', $category)?->name }}
                    <button wire:click="$set('category', '')" class="hover:text-primary-800"><i class="bi bi-x"></i></button>
                </span>
            @endif
            @if ($modality)
                <span class="inline-flex items-center gap-1.5 bg-primary-50 text-primary-600 text-xs font-medium px-3 py-1 rounded-full">
                    {{ ucfirst($modality) }}
                    <button wire:click="$set('modality', '')" class="hover:text-primary-800"><i class="bi bi-x"></i></button>
                </span>
            @endif
            @if ($level)
                <span class="inline-flex items-center gap-1.5 bg-primary-50 text-primary-600 text-xs font-medium px-3 py-1 rounded-full">
                    {{ ucfirst($level) }}
                    <button wire:click="$set('level', '')" class="hover:text-primary-800"><i class="bi bi-x"></i></button>
                </span>
            @endif
            <button wire:click="$set('search',''); $set('category',''); $set('modality',''); $set('level','')"
                    class="text-xs text-slate-400 hover:text-red-500 transition-colors ml-2">
                Limpar tudo
            </button>
        </div>
        @endif
    </div>

    {{-- Loading indicator --}}
    <div wire:loading class="text-center py-4 text-primary-500 text-sm">
        <i class="fa-solid fa-circle-notch fa-spin mr-2"></i> A carregar…
    </div>

    {{-- Results --}}
    <div wire:loading.remove>
        @if ($courses->isEmpty())
            <div class="text-center py-20">
                <i class="fa-solid fa-search text-slate-200" style="font-size:64px;"></i>
                <p class="text-slate-500 mt-5 text-lg font-medium">Nenhum curso encontrado</p>
                <p class="text-slate-400 text-sm mt-2">Tente ajustar os filtros de pesquisa.</p>
            </div>
        @else
            <p class="text-sm text-slate-400 mb-6">{{ $courses->total() }} curso{{ $courses->total() != 1 ? 's' : '' }} encontrado{{ $courses->total() != 1 ? 's' : '' }}</p>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($courses as $course)
                <article class="bg-white rounded-2xl overflow-hidden border border-slate-100 card-hover group">
                    <div class="relative h-44 bg-gradient-to-br from-secondary-800 to-secondary-900 overflow-hidden">
                        @if ($course->image)
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->name }}"
                                 class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fa-solid fa-book-open text-white/20 text-5xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="bg-primary-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $course->category->name ?? '' }}
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="bg-white/90 text-secondary-900 text-xs font-bold px-3 py-1 rounded-full">
                                {{ $course->modality->getLabel() }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="font-display font-bold text-secondary-900 mb-2 group-hover:text-primary-500 transition-colors">
                            <a href="{{ route('courses.show', $course->slug) }}">{{ $course->name }}</a>
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-2">
                            {{ $course->description ? strip_tags($course->description) : '' }}
                        </p>

                        <div class="flex flex-wrap gap-3 text-xs text-slate-400 mb-4">
                            <span class="flex items-center gap-1"><i class="bi bi-clock text-primary-400"></i> {{ $course->duration_hours }}h</span>
                            <span class="flex items-center gap-1"><i class="bi bi-bar-chart text-primary-400"></i> {{ $course->level->getLabel() }}</span>
                            <span class="flex items-center gap-1"><i class="bi bi-patch-check text-primary-400"></i> Certificado</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <p class="font-display font-bold text-primary-500 text-lg">
                                {{ number_format($course->price, 0, ',', '.') }} <span class="text-sm font-medium text-slate-400">Kz</span>
                            </p>
                            <a href="{{ route('courses.show', $course->slug) }}" class="btn-primary text-sm py-2 px-4">
                                Ver curso
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
