<?php

namespace App\Filament\Exports;

use App\Models\Payment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PaymentExporter extends Exporter
{
    protected static ?string $model = Payment::class;

    public function getJobConnection(): ?string
    {
        return 'sync';
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('enrollment.user.name')
                ->label('Aluno'),
            ExportColumn::make('enrollment.user.email')
                ->label('Email'),
            ExportColumn::make('enrollment.course.name')
                ->label('Curso'),
            ExportColumn::make('amount')
                ->label('Valor (Kz)')
                ->formatStateUsing(fn ($state) => number_format((float) $state, 2, ',', '.')),
            ExportColumn::make('method')
                ->label('Método')
                ->formatStateUsing(fn ($state) => $state?->getLabel() ?? $state),
            ExportColumn::make('reference')
                ->label('Referência')
                ->default('—'),
            ExportColumn::make('status')
                ->label('Estado')
                ->formatStateUsing(fn ($state) => $state?->getLabel() ?? $state),
            ExportColumn::make('paid_at')
                ->label('Pago em')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y') ?? '—'),
            ExportColumn::make('created_at')
                ->label('Registado em')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'A exportação de pagamentos foi concluída. '.Number::format($export->successful_rows).' '.str('linha')->plural($export->successful_rows).' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('linha')->plural($failedRowsCount).' falharam.';
        }

        return $body;
    }
}
