<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EnrollmentStatus: string implements HasColor, HasLabel
{
    case Pendente = 'pendente';
    case Aprovado = 'aprovado';
    case Rejeitado = 'rejeitado';
    case Matriculado = 'matriculado';
    case Concluido = 'concluído';
    case Cancelado = 'cancelado';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pendente => 'Pendente',
            self::Aprovado => 'Aprovado',
            self::Rejeitado => 'Rejeitado',
            self::Matriculado => 'Matriculado',
            self::Concluido => 'Concluído',
            self::Cancelado => 'Cancelado',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pendente => 'warning',
            self::Aprovado => 'info',
            self::Matriculado => 'success',
            self::Concluido => 'success',
            self::Rejeitado => 'danger',
            self::Cancelado => 'gray',
        };
    }
}
