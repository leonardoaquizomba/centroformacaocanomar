<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case Transferencia = 'transferencia';
    case Multicaixa = 'multicaixa';

    public function getLabel(): string
    {
        return match ($this) {
            self::Transferencia => 'Transferência Bancária',
            self::Multicaixa => 'Referência Multicaixa',
        };
    }
}
