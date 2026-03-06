<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CourseLevel: string implements HasLabel
{
    case Basico = 'básico';
    case Medio = 'médio';
    case Avancado = 'avançado';

    public function getLabel(): string
    {
        return match ($this) {
            self::Basico => 'Básico',
            self::Medio => 'Médio',
            self::Avancado => 'Avançado',
        };
    }
}
