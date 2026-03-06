<?php

namespace App\Filament\Professor\Widgets;

use App\Models\CourseClass;
use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ProfessorStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        $activeClasses = CourseClass::query()
            ->where('teacher_id', $userId)
            ->where('is_active', true)
            ->count();

        $totalStudents = Enrollment::query()
            ->whereHas('courseClass', fn ($q) => $q->where('teacher_id', $userId))
            ->whereIn('status', ['matriculado', 'concluído'])
            ->distinct('user_id')
            ->count('user_id');

        $totalClasses = CourseClass::query()
            ->where('teacher_id', $userId)
            ->count();

        $pendingGrades = Enrollment::query()
            ->whereHas('courseClass', fn ($q) => $q->where('teacher_id', $userId))
            ->where('status', 'matriculado')
            ->whereDoesntHave('courseClass.grades', fn ($q) => $q->where('teacher_id', $userId))
            ->count();

        return [
            Stat::make('Turmas Activas', $activeClasses)
                ->description('Turmas em curso')
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('Total de Alunos', $totalStudents)
                ->description('Alunos nas suas turmas')
                ->icon('heroicon-o-academic-cap')
                ->color('success'),

            Stat::make('Total de Turmas', $totalClasses)
                ->description('Turmas atribuídas')
                ->icon('heroicon-o-rectangle-stack')
                ->color('info'),

            Stat::make('Avaliações Pendentes', $pendingGrades)
                ->description('Alunos sem nota lançada')
                ->icon('heroicon-o-pencil-square')
                ->color('warning'),
        ];
    }
}
