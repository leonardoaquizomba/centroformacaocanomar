<?php

namespace App\Filament\Resources\Certificates\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CertificateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Certificado')
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('Aluno')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable(),
                        Select::make('course_id')
                            ->label('Curso')
                            ->relationship('course', 'name')
                            ->required()
                            ->searchable(),
                        Select::make('enrollment_id')
                            ->label('Inscrição')
                            ->relationship('enrollment', 'id')
                            ->required(),
                        TextInput::make('code')
                            ->label('Código do Certificado')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('CAN-2026-000001'),
                        DateTimePicker::make('issued_at')
                            ->label('Data de Emissão')
                            ->required()
                            ->displayFormat('d/m/Y'),
                        TextInput::make('file_path')
                            ->label('Caminho do Ficheiro PDF')
                            ->disabled(),
                    ]),
            ]);
    }
}
