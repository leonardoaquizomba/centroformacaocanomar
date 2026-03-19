<?php

namespace App\Filament\Resources\Certificates\Pages;

use App\Events\CertificateIssued;
use App\Filament\Resources\Certificates\CertificateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCertificate extends EditRecord
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if ($this->record->wasChanged('file_path') && $this->record->file_path) {
            CertificateIssued::dispatch($this->record->load(['user', 'course']));
        }
    }
}
