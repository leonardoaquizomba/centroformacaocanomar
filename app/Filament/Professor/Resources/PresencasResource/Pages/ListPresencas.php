<?php

namespace App\Filament\Professor\Resources\PresencasResource\Pages;

use App\Filament\Professor\Resources\PresencasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPresencas extends ListRecords
{
    protected static string $resource = PresencasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
