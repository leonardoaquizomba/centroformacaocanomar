<?php

namespace App\Filament\Resources\Certificates\Pages;

use App\Events\CertificateIssued;
use App\Filament\Resources\Certificates\CertificateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificate extends CreateRecord
{
    protected static string $resource = CertificateResource::class;

    protected function afterCreate(): void
    {
        if ($this->record->file_path) {
            CertificateIssued::dispatch($this->record->load(['user', 'course']));
        }
    }
}
