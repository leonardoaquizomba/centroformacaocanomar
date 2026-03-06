<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados do Pagamento')
                    ->columns(2)
                    ->schema([
                        Select::make('enrollment_id')
                            ->label('Inscrição')
                            ->relationship('enrollment', 'id')
                            ->required()
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->user?->name} – {$record->course?->name}"),
                        TextInput::make('amount')
                            ->label('Valor (AOA)')
                            ->required()
                            ->numeric()
                            ->prefix('Kz'),
                        Select::make('method')
                            ->label('Método de Pagamento')
                            ->options(PaymentMethod::class)
                            ->default(PaymentMethod::Transferencia)
                            ->required(),
                        TextInput::make('reference')
                            ->label('Referência')
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Estado')
                            ->options(PaymentStatus::class)
                            ->default(PaymentStatus::Pendente)
                            ->required(),
                        DateTimePicker::make('paid_at')
                            ->label('Data de Pagamento')
                            ->displayFormat('d/m/Y H:i'),
                    ]),
            ]);
    }
}
