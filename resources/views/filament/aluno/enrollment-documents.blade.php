@if ($documents->isEmpty())
    <div class="flex flex-col items-center justify-center py-8 text-center">
        <x-filament::icon icon="heroicon-o-document" class="h-12 w-12 text-gray-400 mb-3" />
        <p class="text-sm text-gray-500">Nenhum documento foi submetido nesta inscrição.</p>
    </div>
@else
    <ul class="divide-y divide-gray-100">
        @foreach ($documents as $document)
        <li class="flex items-center justify-between py-3 px-1">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-lg bg-primary-50 flex items-center justify-center flex-shrink-0">
                    @if (str_contains($document->mime_type, 'pdf'))
                        <x-filament::icon icon="heroicon-o-document-text" class="h-5 w-5 text-red-500" />
                    @else
                        <x-filament::icon icon="heroicon-o-photo" class="h-5 w-5 text-blue-500" />
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $document->original_name }}</p>
                    <p class="text-xs text-gray-400">{{ $document->type->getLabel() }} · {{ $document->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <a href="{{ route('download.document', $document) }}"
               class="ml-4 flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 transition-colors">
                <x-filament::icon icon="heroicon-o-arrow-down-tray" class="h-3.5 w-3.5" />
                Descarregar
            </a>
        </li>
        @endforeach
    </ul>
@endif
