<?php

namespace App\Filament\Widgets;

use App\Enums\PaymentStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalStudents = User::query()->role('aluno')->count();

        $activeCourses = Course::query()->where('is_active', true)->count();

        $monthlyEnrollments = Enrollment::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $monthlyRevenue = Payment::query()
            ->where('status', PaymentStatus::Pago)
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        return [
            Stat::make('Total de Alunos', $totalStudents)
                ->description('Alunos registados')
                ->icon('heroicon-o-academic-cap')
                ->color('primary'),

            Stat::make('Cursos Activos', $activeCourses)
                ->description('Cursos disponíveis')
                ->icon('heroicon-o-book-open')
                ->color('success'),

            Stat::make('Inscrições este Mês', $monthlyEnrollments)
                ->description('Novas inscrições em '.now()->translatedFormat('F Y'))
                ->icon('heroicon-o-clipboard-document-list')
                ->color('warning'),

            Stat::make('Receita este Mês', 'Kz '.number_format($monthlyRevenue, 2, ',', '.'))
                ->description('Pagamentos confirmados em '.now()->translatedFormat('F Y'))
                ->icon('heroicon-o-banknotes')
                ->color('info'),
        ];
    }
}
