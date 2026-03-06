<?php

namespace App\Filament\Aluno\Resources;

use App\Filament\Aluno\Resources\MateriaisResource\Pages\ListMateriais;
use App\Models\CourseMaterial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MateriaisResource extends Resource
{
    protected static ?string $model = CourseMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderOpen;

    protected static ?string $navigationLabel = 'Materiais';

    protected static ?string $modelLabel = 'Material';

    protected static ?string $pluralModelLabel = 'Materiais de Apoio';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('courseClass.enrollments', fn (Builder $q) => $q
                ->where('user_id', Auth::id())
                ->whereIn('status', ['matriculado', 'concluído'])
            );
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                TextColumn::make('courseClass.name')
                    ->label('Turma')
                    ->sortable(),
                TextColumn::make('courseClass.course.name')
                    ->label('Curso'),
                TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(50)
                    ->placeholder('—'),
                TextColumn::make('original_name')
                    ->label('Ficheiro'),
                TextColumn::make('created_at')
                    ->label('Adicionado em')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->recordActions([])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMateriais::route('/'),
        ];
    }
}
