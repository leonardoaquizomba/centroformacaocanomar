<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DocumentType: string implements HasLabel
{
    case Bi = 'bi';
    case Foto = 'foto';
    case Comprovativo = 'comprovativo';
    case Outro = 'outro';

    public function getLabel(): string
    {
        return match ($this) {
            self::Bi => 'Bilhete de Identidade',
            self::Foto => 'Fotografia',
            self::Comprovativo => 'Comprovativo',
            self::Outro => 'Outro',
        };
    }
}
