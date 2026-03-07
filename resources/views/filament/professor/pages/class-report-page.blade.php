<x-filament-panels::page>
    {{-- Class Selector --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
        <label for="class-select" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Seleccionar Turma
        </label>
        <select
            id="class-select"
            wire:model.live="selectedClassId"
            class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-gray-800 dark:text-white sm:max-w-sm"
        >
            <option value="">— Escolha uma turma —</option>
            @foreach ($this->getClassOptions() as $id => $label)
                <option value="{{ $id }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    @if (! $selectedClassId || ! $classInfo)
        <div class="flex flex-col items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-16 text-center shadow-sm dark:border-white/10 dark:bg-gray-900">
            <x-heroicon-o-chart-bar class="mb-4 h-12 w-12 text-gray-400" />
            <p class="text-base font-medium text-gray-700 dark:text-gray-300">Seleccione uma turma para ver o relatório.</p>
        </div>
    @else
        {{-- Class Info Header --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-xs text-gray-500 dark:text-gray-400">Curso</p>
                <p class="mt-1 font-semibold text-gray-800 dark:text-white">{{ $classInfo['course_name'] }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-xs text-gray-500 dark:text-gray-400">Turma</p>
                <p class="mt-1 font-semibold text-gray-800 dark:text-white">{{ $classInfo['class_name'] }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-xs text-gray-500 dark:text-gray-400">Período</p>
                <p class="mt-1 font-semibold text-gray-800 dark:text-white">{{ $classInfo['start_date'] }} – {{ $classInfo['end_date'] }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
                <p class="text-xs text-gray-500 dark:text-gray-400">Inscritos / Vagas</p>
                <p class="mt-1 font-semibold text-gray-800 dark:text-white">
                    {{ $classInfo['enrolled'] }} / {{ $classInfo['total_slots'] }}
                    @if ($classInfo['is_active'])
                        <span class="ml-2 inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">Activa</span>
                    @else
                        <span class="ml-2 inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-300">Inactiva</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Student Report Table --}}
        @if (empty($studentReports))
            <div class="flex flex-col items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-12 text-center shadow-sm dark:border-white/10 dark:bg-gray-900">
                <x-heroicon-o-users class="mb-3 h-10 w-10 text-gray-400" />
                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum aluno inscrito nesta turma.</p>
            </div>
        @else
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-white/10">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Aluno</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Estado</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Sessões</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Presenças</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Faltas</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Atrasos</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">% Presença</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Nº Avaliações</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Média</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @foreach ($studentReports as $student)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $student['name'] }}</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $student['enrollment_status'] }}</td>
                                    <td class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">{{ $student['total_sessions'] ?: '—' }}</td>
                                    <td class="px-4 py-3 text-center text-green-600 dark:text-green-400">{{ $student['present'] ?: '—' }}</td>
                                    <td class="px-4 py-3 text-center text-red-500 dark:text-red-400">{{ $student['absent'] ?: '—' }}</td>
                                    <td class="px-4 py-3 text-center text-yellow-600 dark:text-yellow-400">{{ $student['late'] ?: '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($student['attendance_pct'] !== null)
                                            <span @class([
                                                'inline-block rounded-full px-2 py-0.5 text-xs font-semibold',
                                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' => $student['attendance_pct'] >= 75,
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' => $student['attendance_pct'] >= 50 && $student['attendance_pct'] < 75,
                                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' => $student['attendance_pct'] < 50,
                                            ])>{{ $student['attendance_pct'] }}%</span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">{{ $student['grade_count'] ?: '—' }}</td>
                                    <td class="px-4 py-3 text-center font-semibold text-gray-800 dark:text-white">
                                        {{ $student['grade_avg'] !== null ? $student['grade_avg'] : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif
</x-filament-panels::page>
