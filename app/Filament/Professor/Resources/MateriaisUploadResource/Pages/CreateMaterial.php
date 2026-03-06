<?php

namespace App\Filament\Professor\Resources\MateriaisUploadResource\Pages;

use App\Filament\Professor\Resources\MateriaisUploadResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMaterial extends CreateRecord
{
    protected static string $resource = MateriaisUploadResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
