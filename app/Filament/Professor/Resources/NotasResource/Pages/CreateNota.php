<?php

namespace App\Filament\Professor\Resources\NotasResource\Pages;

use App\Filament\Professor\Resources\NotasResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateNota extends CreateRecord
{
    protected static string $resource = NotasResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['teacher_id'] = Auth::id();

        return $data;
    }
}
