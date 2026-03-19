<?php

namespace App\Filament\Professor\Resources\NotasResource\Pages;

use App\Filament\Professor\Resources\NotasResource;
use App\Models\Enrollment;
use Filament\Resources\Pages\EditRecord;

class EditNota extends EditRecord
{
    protected static string $resource = NotasResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = Enrollment::find($data['enrollment_id'])?->user_id ?? $this->record->user_id;

        return $data;
    }
}
