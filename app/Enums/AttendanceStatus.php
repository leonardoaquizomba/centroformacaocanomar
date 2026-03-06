<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AttendanceStatus: string implements HasColor, HasLabel
{
    case Presente = 'presente';
    case Ausente = 'ausente';
    case Atrasado = 'atrasado';
    case Justificado = 'justificado';

    public function getLabel(): string
    {
        return match ($this) {
            self::Presente => 'Presente',
            self::Ausente => 'Ausente',
            self::Atrasado => 'Atrasado',
            self::Justificado => 'Justificado',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Presente => 'success',
            self::Ausente => 'danger',
            self::Atrasado => 'warning',
            self::Justificado => 'info',
        };
    }
}
