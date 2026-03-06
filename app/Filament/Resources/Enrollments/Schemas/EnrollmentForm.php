<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use App\Enums\EnrollmentStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados da Inscrição')
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
                        Select::make('course_class_id')
                            ->label('Turma')
                            ->relationship('courseClass', 'name')
                            ->nullable()
                            ->searchable(),
                        Select::make('status')
                            ->label('Estado')
                            ->options(EnrollmentStatus::class)
                            ->default(EnrollmentStatus::Pendente)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Notas')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
