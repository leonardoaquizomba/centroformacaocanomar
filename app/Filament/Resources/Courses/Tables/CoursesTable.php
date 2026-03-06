<?php

namespace App\Filament\Resources\Courses\Tables;

use App\Enums\CourseLevel;
use App\Enums\CourseModality;
use App\Models\CourseCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->badge()
                    ->sortable(),
                TextColumn::make('duration_hours')
                    ->label('Horas')
                    ->numeric()
                    ->sortable()
                    ->suffix('h'),
                TextColumn::make('modality')
                    ->label('Modalidade')
                    ->badge(),
                TextColumn::make('level')
                    ->label('Nível')
                    ->badge(),
                TextColumn::make('price')
                    ->label('Preço')
                    ->numeric(decimalPlaces: 0)
                    ->suffix(' Kz')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('course_category_id')
                    ->label('Categoria')
                    ->options(CourseCategory::pluck('name', 'id')),
                SelectFilter::make('modality')
                    ->label('Modalidade')
                    ->options(CourseModality::class),
                SelectFilter::make('level')
                    ->label('Nível')
                    ->options(CourseLevel::class),
                TernaryFilter::make('is_active')
                    ->label('Activo'),
                TernaryFilter::make('is_featured')
                    ->label('Em Destaque'),
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
