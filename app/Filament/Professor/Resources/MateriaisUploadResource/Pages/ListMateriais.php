<?php

namespace App\Filament\Professor\Resources\MateriaisUploadResource\Pages;

use App\Filament\Professor\Resources\MateriaisUploadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMateriais extends ListRecords
{
    protected static string $resource = MateriaisUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
