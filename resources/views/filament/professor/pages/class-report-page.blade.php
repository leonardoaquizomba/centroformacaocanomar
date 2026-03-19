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
        <div wire:loading.delay class="rounded-xl border border-gray-200 bg-white px-6 py-4 text-center text-sm text-gray-500 shadow-sm dark:border-white/10 dark:bg-gray-900 dark:text-gray-400">
            A carregar relatório…
        </div>

        <div wire:loading.remove>
            {{-- Class Info Header --}}
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
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
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
                    <p class="text-xs text-gray-500 dark:text-gray-400">% Presença Média</p>
                    @if ($classInfo['class_avg_attendance'] !== null)
                        <p @class([
                            'mt-1 font-semibold',
                            'text-green-600 dark:text-green-400'  => $classInfo['class_avg_attendance'] >= 75,
                            'text-yellow-600 dark:text-yellow-400' => $classInfo['class_avg_attendance'] >= 50 && $classInfo['class_avg_attendance'] < 75,
                            'text-red-600 dark:text-red-400'      => $classInfo['class_avg_attendance'] < 50,
                        ])>{{ $classInfo['class_avg_attendance'] }}%</p>
                    @else
                        <p class="mt-1 font-semibold text-gray-400">—</p>
                    @endif
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-gray-900">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Média de Notas</p>
                    @if ($classInfo['class_avg_grade'] !== null)
                        @php
                            $gradeMax = $classInfo['class_avg_grade_max'] ?: 20;
                            $gradePct = $gradeMax > 0 ? $classInfo['class_avg_grade'] / $gradeMax * 100 : 0;
                        @endphp
                        <p @class([
                            'mt-1 font-semibold',
                            'text-green-600 dark:text-green-400'   => $gradePct >= 70,
                            'text-yellow-600 dark:text-yellow-400' => $gradePct >= 50 && $gradePct < 70,
                            'text-red-600 dark:text-red-400'       => $gradePct < 50,
                        ])>{{ $classInfo['class_avg_grade'] }} / {{ $gradeMax }}</p>
                    @else
                        <p class="mt-1 font-semibold text-gray-400">—</p>
                    @endif
                </div>
            </div>

            {{-- Student Report Table --}}
            @if (empty($studentReports))
                <div class="mt-4 flex flex-col items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-12 text-center shadow-sm dark:border-white/10 dark:bg-gray-900">
                    <x-heroicon-o-users class="mb-3 h-10 w-10 text-gray-400" />
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum aluno inscrito nesta turma.</p>
                </div>
            @else
                <div class="mt-4 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-gray-900">
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
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Justificadas</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">% Presença</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Avaliações</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Média</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                                @foreach ($studentReports as $student)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $student['name'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $student['enrollment_status_class'] }}">
                                                {{ $student['enrollment_status'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">{{ $student['total_sessions'] ?: '—' }}</td>
                                        <td class="px-4 py-3 text-center text-green-600 dark:text-green-400">{{ $student['present'] ?: '—' }}</td>
                                        <td class="px-4 py-3 text-center text-red-500 dark:text-red-400">{{ $student['absent'] ?: '—' }}</td>
                                        <td class="px-4 py-3 text-center text-yellow-600 dark:text-yellow-400">{{ $student['late'] ?: '—' }}</td>
                                        <td class="px-4 py-3 text-center text-blue-500 dark:text-blue-400">{{ $student['justified'] ?: '—' }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if ($student['attendance_pct'] !== null)
                                                <span @class([
                                                    'inline-block rounded-full px-2 py-0.5 text-xs font-semibold',
                                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'   => $student['attendance_pct'] >= 75,
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' => $student['attendance_pct'] >= 50 && $student['attendance_pct'] < 75,
                                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'           => $student['attendance_pct'] < 50,
                                                ])>{{ $student['attendance_pct'] }}%</span>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">{{ $student['grade_count'] ?: '—' }}</td>
                                        <td class="px-4 py-3 text-center font-semibold">
                                            @if ($student['grade_avg'] !== null)
                                                @php
                                                    $max = $student['grade_avg_max'] ?: 20;
                                                    $pct = $max > 0 ? $student['grade_avg'] / $max * 100 : 0;
                                                @endphp
                                                <span @class([
                                                    'text-green-600 dark:text-green-400'   => $pct >= 70,
                                                    'text-yellow-600 dark:text-yellow-400' => $pct >= 50 && $pct < 70,
                                                    'text-red-600 dark:text-red-400'       => $pct < 50,
                                                ])>{{ $student['grade_avg'] }} / {{ $max }}</span>
                                            @else
                                                <span class="font-normal text-gray-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- Summary totals row --}}
                            <tfoot class="bg-gray-50 dark:bg-white/5">
                                <tr class="border-t-2 border-gray-300 dark:border-white/20">
                                    <td class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Totais / Médias</td>
                                    <td class="px-4 py-3"></td>
                                    <td class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300">
                                        {{ collect($studentReports)->sum('total_sessions') ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs font-semibold text-green-600 dark:text-green-400">
                                        {{ collect($studentReports)->sum('present') ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs font-semibold text-red-500 dark:text-red-400">
                                        {{ collect($studentReports)->sum('absent') ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs font-semibold text-yellow-600 dark:text-yellow-400">
                                        {{ collect($studentReports)->sum('late') ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs font-semibold text-blue-500 dark:text-blue-400">
                                        {{ collect($studentReports)->sum('justified') ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($classInfo['class_avg_attendance'] !== null)
                                            <span @class([
                                                'inline-block rounded-full px-2 py-0.5 text-xs font-semibold',
                                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'   => $classInfo['class_avg_attendance'] >= 75,
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' => $classInfo['class_avg_attendance'] >= 50 && $classInfo['class_avg_attendance'] < 75,
                                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'           => $classInfo['class_avg_attendance'] < 50,
                                            ])>{{ $classInfo['class_avg_attendance'] }}%</span>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300">
                                        {{ collect($studentReports)->sum('grade_count') ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs font-semibold">
                                        @if ($classInfo['class_avg_grade'] !== null)
                                            @php
                                                $avgMax = $classInfo['class_avg_grade_max'] ?: 20;
                                                $avgPct = $avgMax > 0 ? $classInfo['class_avg_grade'] / $avgMax * 100 : 0;
                                            @endphp
                                            <span @class([
                                                'text-green-600 dark:text-green-400'   => $avgPct >= 70,
                                                'text-yellow-600 dark:text-yellow-400' => $avgPct >= 50 && $avgPct < 70,
                                                'text-red-600 dark:text-red-400'       => $avgPct < 50,
                                            ])>{{ $classInfo['class_avg_grade'] }} / {{ $avgMax }}</span>
                                        @else
                                            <span class="font-normal text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    @endif
</x-filament-panels::page>
