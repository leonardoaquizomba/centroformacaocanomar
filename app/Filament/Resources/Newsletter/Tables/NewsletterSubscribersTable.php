<?php

namespace App\Filament\Resources\Newsletter\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NewsletterSubscribersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subscribed_at')
                    ->label('Subscrito em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->getStateUsing(fn (mixed $record): string => $record->unsubscribed_at ? 'Cancelado' : 'Activo')
                    ->color(fn (string $state): string => match ($state) {
                        'Activo' => 'success',
                        default => 'danger',
                    }),
            ])
            ->defaultSort('subscribed_at', 'desc')
            ->filters([
                Filter::make('active')
                    ->label('Apenas activos')
                    ->query(fn (Builder $query) => $query->whereNull('unsubscribed_at'))
                    ->default(),
                Filter::make('unsubscribed')
                    ->label('Cancelados')
                    ->query(fn (Builder $query) => $query->whereNotNull('unsubscribed_at')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
