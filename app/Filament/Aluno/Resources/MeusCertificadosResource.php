<?php

namespace App\Filament\Aluno\Resources;

use App\Filament\Aluno\Resources\MeusCertificadosResource\Pages\ListMeusCertificados;
use App\Models\Certificate;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MeusCertificadosResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    protected static ?string $navigationLabel = 'Os Meus Certificados';

    protected static ?string $modelLabel = 'Certificado';

    protected static ?string $pluralModelLabel = 'Os Meus Certificados';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 2;

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
                TextColumn::make('code')
                    ->label('Código')
                    ->badge()
                    ->copyable()
                    ->searchable(),
                TextColumn::make('course.name')
                    ->label('Curso')
                    ->searchable(),
                TextColumn::make('issued_at')
                    ->label('Emitido em')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                IconColumn::make('file_path')
                    ->label('PDF disponível')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-text')
                    ->falseIcon('heroicon-o-x-mark'),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Descarregar PDF')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('primary')
                    ->visible(fn (Certificate $record): bool => (bool) $record->file_path)
                    ->url(fn (Certificate $record): string => route('download.certificate', $record))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([])
            ->defaultSort('issued_at', 'desc')
            ->emptyStateHeading('Ainda não tem certificados')
            ->emptyStateDescription('Os seus certificados aparecerão aqui após a conclusão de um curso.')
            ->emptyStateIcon(Heroicon::OutlinedDocumentCheck);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeusCertificados::route('/'),
        ];
    }
}
