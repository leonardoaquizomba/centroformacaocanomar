<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DayOfWeek: string implements HasLabel
{
    case Segunda = 'segunda';
    case Terca = 'terça';
    case Quarta = 'quarta';
    case Quinta = 'quinta';
    case Sexta = 'sexta';
    case Sabado = 'sábado';
    case Domingo = 'domingo';

    public function getLabel(): string
    {
        return match ($this) {
            self::Segunda => 'Segunda-feira',
            self::Terca => 'Terça-feira',
            self::Quarta => 'Quarta-feira',
            self::Quinta => 'Quinta-feira',
            self::Sexta => 'Sexta-feira',
            self::Sabado => 'Sábado',
            self::Domingo => 'Domingo',
        };
    }
}
