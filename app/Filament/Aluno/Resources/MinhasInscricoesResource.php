<?php

namespace App\Filament\Aluno\Resources;

use App\Filament\Aluno\Resources\MinhasInscricoesResource\Pages\ListMinhasInscricoes;
use App\Models\Enrollment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MinhasInscricoesResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'As Minhas Inscrições';

    protected static ?string $modelLabel = 'Inscrição';

    protected static ?string $pluralModelLabel = 'As Minhas Inscrições';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 1;

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
                TextColumn::make('course.name')
                    ->label('Curso')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('courseClass.name')
                    ->label('Turma')
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge(),
                TextColumn::make('documents_count')
                    ->label('Docs.')
                    ->counts('documents')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('created_at')
                    ->label('Data de Inscrição')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('documents')
                    ->label('Documentos')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->modalHeading(fn (Enrollment $record): string => 'Documentos — '.$record->course->name)
                    ->modalContent(fn (Enrollment $record) => view(
                        'filament.aluno.enrollment-documents',
                        ['documents' => $record->documents]
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fechar'),
            ])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMinhasInscricoes::route('/'),
        ];
    }
}
