<?php

namespace App\Filament\Aluno\Widgets;

use App\Enums\EnrollmentStatus;
use App\Models\Certificate;
use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AlunoStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        $totalEnrollments = Enrollment::query()
            ->where('user_id', $userId)
            ->count();

        $activeEnrollments = Enrollment::query()
            ->where('user_id', $userId)
            ->whereIn('status', [EnrollmentStatus::Aprovado, EnrollmentStatus::Matriculado])
            ->count();

        $completedCourses = Enrollment::query()
            ->where('user_id', $userId)
            ->where('status', EnrollmentStatus::Concluido)
            ->count();

        $certificates = Certificate::query()
            ->where('user_id', $userId)
            ->count();

        return [
            Stat::make('Inscrições Activas', $activeEnrollments)
                ->description('Cursos em curso')
                ->icon('heroicon-o-academic-cap')
                ->color('primary'),

            Stat::make('Cursos Concluídos', $completedCourses)
                ->description('Formações concluídas')
                ->icon('heroicon-o-check-badge')
                ->color('success'),

            Stat::make('Total de Inscrições', $totalEnrollments)
                ->description('Desde o início')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('info'),

            Stat::make('Certificados', $certificates)
                ->description('Certificados emitidos')
                ->icon('heroicon-o-document-check')
                ->color('warning'),
        ];
    }
}
