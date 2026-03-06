<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Mensagem')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->disabled(),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->required()
                            ->disabled(),
                        TextInput::make('phone')
                            ->label('Telefone')
                            ->disabled(),
                        Toggle::make('is_read')
                            ->label('Lida'),
                        Textarea::make('message')
                            ->label('Mensagem')
                            ->required()
                            ->disabled()
                            ->columnSpanFull()
                            ->rows(5),
                    ]),
            ]);
    }
}
