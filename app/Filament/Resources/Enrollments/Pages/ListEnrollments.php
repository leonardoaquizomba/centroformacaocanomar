<?php

namespace App\Filament\Resources\Enrollments\Pages;

use App\Filament\Exports\EnrollmentExporter;
use App\Filament\Resources\Enrollments\EnrollmentResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListEnrollments extends ListRecords
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->exporter(EnrollmentExporter::class)->label('Exportar'),
            CreateAction::make(),
        ];
    }
}
