<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Exports\PaymentExporter;
use App\Filament\Resources\Payments\PaymentResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->exporter(PaymentExporter::class)->label('Exportar'),
            CreateAction::make(),
        ];
    }
}
