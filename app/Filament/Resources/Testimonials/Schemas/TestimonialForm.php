<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Depoimento')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('role')
                            ->label('Cargo / Curso')
                            ->maxLength(255),
                        FileUpload::make('photo_path')
                            ->label('Foto')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->directory('testimonials')
                            ->avatar(),
                        TextInput::make('order')
                            ->label('Ordem')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Textarea::make('content')
                            ->label('Depoimento')
                            ->required()
                            ->columnSpanFull()
                            ->rows(4),
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),
                    ]),
            ]);
    }
}
