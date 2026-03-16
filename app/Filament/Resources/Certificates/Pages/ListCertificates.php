<?php

namespace App\Filament\Resources\Certificates\Pages;

use App\Filament\Exports\CertificateExporter;
use App\Filament\Resources\Certificates\CertificateResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListCertificates extends ListRecords
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->exporter(CertificateExporter::class)->label('Exportar'),
            CreateAction::make(),
        ];
    }
}
