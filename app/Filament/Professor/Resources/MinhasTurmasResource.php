<?php

namespace App\Filament\Professor\Resources;

use App\Filament\Professor\Resources\MinhasTurmasResource\Pages\ListMinhasTurmas;
use App\Models\CourseClass;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MinhasTurmasResource extends Resource
{
    protected static ?string $model = CourseClass::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'As Minhas Turmas';

    protected static ?string $modelLabel = 'Turma';

    protected static ?string $pluralModelLabel = 'As Minhas Turmas';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('teacher_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
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
                TextColumn::make('enrollments_count')
                    ->label('Alunos')
                    ->counts('enrollments')
                    ->badge(),
                TextColumn::make('start_date')
                    ->label('Início')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Fim')
                    ->date('d/m/Y'),
                IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean(),
            ])
            ->recordActions([])
            ->toolbarActions([])
            ->defaultSort('start_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMinhasTurmas::route('/'),
        ];
    }
}
