<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CourseModality: string implements HasColor, HasLabel
{
    case Presencial = 'presencial';
    case Online = 'online';
    case Misto = 'misto';

    public function getLabel(): string
    {
        return match ($this) {
            self::Presencial => 'Presencial',
            self::Online => 'Online',
            self::Misto => 'Misto',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Presencial => 'success',
            self::Online => 'info',
            self::Misto => 'warning',
        };
    }
}
