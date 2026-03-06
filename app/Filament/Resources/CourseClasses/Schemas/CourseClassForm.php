<?php

namespace App\Filament\Resources\CourseClasses\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CourseClassForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Turma')
                    ->columns(2)
                    ->schema([
                        Select::make('course_id')
                            ->label('Curso')
                            ->relationship('course', 'name')
                            ->required()
                            ->searchable(),
                        Select::make('teacher_id')
                            ->label('Professor')
                            ->options(
                                User::role('professor')->pluck('name', 'id')
                            )
                            ->searchable()
                            ->nullable(),
                        TextInput::make('name')
                            ->label('Nome da Turma')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('max_students')
                            ->label('Máximo de Alunos')
                            ->required()
                            ->numeric()
                            ->default(30),
                        DatePicker::make('start_date')
                            ->label('Data de Início')
                            ->required()
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('end_date')
                            ->label('Data de Fim')
                            ->required()
                            ->displayFormat('d/m/Y'),
                        Toggle::make('is_active')
                            ->label('Activa')
                            ->default(true),
                    ]),
                Section::make('Horários')
                    ->schema([
                        Repeater::make('schedules')
                            ->label('Horários')
                            ->relationship()
                            ->schema([
                                Select::make('day_of_week')
                                    ->label('Dia da Semana')
                                    ->options([
                                        'segunda' => 'Segunda-feira',
                                        'terça' => 'Terça-feira',
                                        'quarta' => 'Quarta-feira',
                                        'quinta' => 'Quinta-feira',
                                        'sexta' => 'Sexta-feira',
                                        'sábado' => 'Sábado',
                                        'domingo' => 'Domingo',
                                    ])
                                    ->required(),
                                TimePicker::make('start_time')
                                    ->label('Hora de Início')
                                    ->required(),
                                TimePicker::make('end_time')
                                    ->label('Hora de Fim')
                                    ->required(),
                                TextInput::make('location')
                                    ->label('Local / Sala'),
                            ])
                            ->columns(4)
                            ->addActionLabel('Adicionar Horário'),
                    ]),
            ]);
    }
}
