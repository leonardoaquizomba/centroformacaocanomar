<?php

namespace App\Filament\Resources\Enrollments\RelationManagers;

use App\Models\EnrollmentDocument;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documentos';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_name')
            ->columns([
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->getLabel()),
                TextColumn::make('original_name')
                    ->label('Nome do ficheiro')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('mime_type')
                    ->label('Formato')
                    ->formatStateUsing(fn (string $state): string => strtoupper(last(explode('/', $state))))
                    ->badge()
                    ->color('gray'),
                TextColumn::make('created_at')
                    ->label('Submetido em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->headerActions([])
            ->recordActions([
                Action::make('download')
                    ->label('Descarregar')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->url(fn (EnrollmentDocument $record): string => route('download.document', $record))
                    ->openUrlInNewTab(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
