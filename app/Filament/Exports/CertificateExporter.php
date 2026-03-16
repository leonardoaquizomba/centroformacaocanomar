<?php

namespace App\Filament\Exports;

use App\Models\Certificate;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class CertificateExporter extends Exporter
{
    protected static ?string $model = Certificate::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code')
                ->label('Código'),
            ExportColumn::make('user.name')
                ->label('Aluno'),
            ExportColumn::make('user.email')
                ->label('Email'),
            ExportColumn::make('course.name')
                ->label('Curso'),
            ExportColumn::make('issued_at')
                ->label('Emitido em')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y')),
            ExportColumn::make('file_path')
                ->label('PDF disponível')
                ->formatStateUsing(fn ($state) => $state ? 'Sim' : 'Não'),
            ExportColumn::make('created_at')
                ->label('Criado em')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'A exportação de certificados foi concluída. '.Number::format($export->successful_rows).' '.str('linha')->plural($export->successful_rows).' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('linha')->plural($failedRowsCount).' falharam.';
        }

        return $body;
    }
}
