<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Models\CourseCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações Gerais')
                    ->columns(2)
                    ->schema([
                        Select::make('course_category_id')
                            ->label('Categoria')
                            ->options(CourseCategory::where('is_active', true)->pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                        TextInput::make('name')
                            ->label('Nome do Curso')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('certification_type')
                            ->label('Tipo de Certificação')
                            ->maxLength(255),
                        RichEditor::make('description')
                            ->label('Descrição')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('prerequisites')
                            ->label('Pré-requisitos')
                            ->columnSpanFull(),
                    ]),
                Section::make('Detalhes do Curso')
                    ->columns(2)
                    ->schema([
                        TextInput::make('duration_hours')
                            ->label('Duração (horas)')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        Select::make('modality')
                            ->label('Modalidade')
                            ->options([
                                'presencial' => 'Presencial',
                                'online' => 'Online',
                                'misto' => 'Misto',
                            ])
                            ->default('presencial')
                            ->required(),
                        Select::make('level')
                            ->label('Nível')
                            ->options([
                                'básico' => 'Básico',
                                'médio' => 'Médio',
                                'avançado' => 'Avançado',
                            ])
                            ->default('básico')
                            ->required(),
                        TextInput::make('price')
                            ->label('Preço (AOA)')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->prefix('Kz'),
                    ]),
                Section::make('Imagem e Estado')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image')
                            ->label('Imagem de Capa')
                            ->image()
                            ->directory('courses')
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Em Destaque'),
                    ]),
            ]);
    }
}
