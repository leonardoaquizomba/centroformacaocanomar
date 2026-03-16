<?php

namespace App\Filament\Exports;

use App\Models\Enrollment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class EnrollmentExporter extends Exporter
{
    protected static ?string $model = Enrollment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('user.name')
                ->label('Aluno'),
            ExportColumn::make('user.email')
                ->label('Email'),
            ExportColumn::make('course.name')
                ->label('Curso'),
            ExportColumn::make('courseClass.name')
                ->label('Turma')
                ->default('—'),
            ExportColumn::make('status')
                ->label('Estado')
                ->formatStateUsing(fn ($state) => $state?->getLabel() ?? $state),
            ExportColumn::make('approved_at')
                ->label('Aprovado em')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y') ?? '—'),
            ExportColumn::make('notes')
                ->label('Observações')
                ->default('—'),
            ExportColumn::make('created_at')
                ->label('Inscrito em')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'A exportação de inscrições foi concluída. '.Number::format($export->successful_rows).' '.str('linha')->plural($export->successful_rows).' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('linha')->plural($failedRowsCount).' falharam.';
        }

        return $body;
    }
}
