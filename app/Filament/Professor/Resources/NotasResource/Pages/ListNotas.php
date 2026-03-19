<?php

namespace App\Filament\Professor\Resources\NotasResource\Pages;

use App\Filament\Professor\Resources\NotasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNotas extends ListRecords
{
    protected static string $resource = NotasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
