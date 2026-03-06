<x-filament-panels::page>
    @php
        $dayMap = [
            0 => 'domingo',
            1 => 'segunda',
            2 => 'terça',
            3 => 'quarta',
            4 => 'quinta',
            5 => 'sexta',
            6 => 'sábado',
        ];

        $hasAnySchedule = collect($schedulesByDay)->flatten(1)->isNotEmpty();
    @endphp

    @if (! $hasAnySchedule)
        <div class="flex flex-col items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-16 text-center shadow-sm dark:border-white/10 dark:bg-gray-900">
            <x-heroicon-o-calendar-days class="mb-4 h-12 w-12 text-gray-400" />
            <p class="text-base font-medium text-gray-700 dark:text-gray-300">Não tem aulas agendadas.</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Após a aprovação das suas inscrições, as aulas aparecerão aqui.</p>
        </div>
    @else
        <div
            x-data="{ today: new Date().getDay() }"
            class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-7"
        >
            @foreach (\App\Enums\DayOfWeek::cases() as $day)
                @php
                    $slots = $schedulesByDay[$day->value] ?? [];
                    $jsDay = array_search($day->value, $dayMap);
                @endphp

                <div
                    x-bind:class="today === {{ $jsDay }} ? 'ring-2 ring-primary-500' : ''"
                    class="flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900"
                >
                    {{-- Day header --}}
                    <div
                        x-bind:class="today === {{ $jsDay }} ? 'bg-primary-500 text-white' : 'bg-gray-50 text-gray-600 dark:bg-white/5 dark:text-gray-400'"
                        class="rounded-t-xl px-3 py-2 text-center text-xs font-semibold uppercase tracking-wide"
                    >
                        {{ $day->getLabel() }}
                    </div>

                    {{-- Schedule slots --}}
                    <div class="flex flex-1 flex-col gap-2 p-2">
                        @forelse ($slots as $slot)
                            <div class="rounded-lg border border-primary-100 bg-primary-50 p-2 dark:border-primary-900 dark:bg-primary-950">
                                <p class="truncate text-xs font-semibold text-primary-800 dark:text-primary-200">
                                    {{ $slot['course'] }}
                                </p>
                                <p class="truncate text-xs text-primary-600 dark:text-primary-400">
                                    {{ $slot['class'] }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $slot['start_time'] }} – {{ $slot['end_time'] }}
                                </p>
                                @if ($slot['location'])
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        <x-heroicon-o-map-pin class="inline h-3 w-3" /> {{ $slot['location'] }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="flex-1 py-4 text-center text-xs text-gray-400 dark:text-gray-600">—</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-filament-panels::page>
