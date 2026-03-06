<?php

namespace App\Filament\Professor\Resources\PresencasResource\Pages;

use App\Filament\Professor\Resources\PresencasResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePresenca extends CreateRecord
{
    protected static string $resource = PresencasResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = $data['user_id'] ?? null;

        return $data;
    }
}
