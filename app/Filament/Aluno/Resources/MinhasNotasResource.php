<?php

namespace App\Filament\Aluno\Resources;

use App\Filament\Aluno\Resources\MinhasNotasResource\Pages\ListMinhasNotas;
use App\Models\Grade;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MinhasNotasResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'As Minhas Notas';

    protected static ?string $modelLabel = 'Nota';

    protected static ?string $pluralModelLabel = 'As Minhas Notas';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('courseClass.course.name')
                    ->label('Curso')
                    ->sortable(),
                TextColumn::make('courseClass.name')
                    ->label('Turma'),
                TextColumn::make('name')
                    ->label('Avaliação')
                    ->searchable(),
                TextColumn::make('score')
                    ->label('Nota')
                    ->numeric(decimalPlaces: 1)
                    ->suffix(fn (Grade $record): string => ' / '.number_format((float) $record->max_score, 1)),
                TextColumn::make('graded_at')
                    ->label('Data')
                    ->dateTime('d/m/Y')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->recordActions([])
            ->toolbarActions([])
            ->defaultSort('graded_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMinhasNotas::route('/'),
        ];
    }
}
