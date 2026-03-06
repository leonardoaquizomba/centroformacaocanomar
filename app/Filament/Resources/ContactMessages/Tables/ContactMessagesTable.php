<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->weight(fn (ContactMessage $record) => $record->is_read ? null : 'bold'),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telefone')
                    ->placeholder('—'),
                TextColumn::make('message')
                    ->label('Mensagem')
                    ->limit(60),
                IconColumn::make('is_read')
                    ->label('Lida')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Recebida em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Lida'),
            ])
            ->recordActions([
                Action::make('markAsRead')
                    ->label('Marcar como Lida')
                    ->icon('heroicon-o-envelope-open')
                    ->color('info')
                    ->visible(fn (ContactMessage $record): bool => ! $record->is_read)
                    ->action(fn (ContactMessage $record) => $record->update(['is_read' => true])),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
