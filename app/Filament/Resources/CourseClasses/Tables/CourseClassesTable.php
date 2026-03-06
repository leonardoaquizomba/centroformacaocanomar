<?php

namespace App\Filament\Resources\CourseClasses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourseClassesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.name')
                    ->label('Curso')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Turma')
                    ->searchable(),
                TextColumn::make('teacher.name')
                    ->label('Professor')
                    ->searchable()
                    ->placeholder('Sem professor'),
                TextColumn::make('start_date')
                    ->label('Início')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Fim')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('max_students')
                    ->label('Máx. Alunos')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
