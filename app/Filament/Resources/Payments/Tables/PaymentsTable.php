<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Actions\ProcessPaymentApproval;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('enrollment.user.name')
                    ->label('Aluno')
                    ->searchable(),
                TextColumn::make('enrollment.course.name')
                    ->label('Curso')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Valor')
                    ->numeric(decimalPlaces: 0)
                    ->suffix(' Kz')
                    ->sortable(),
                TextColumn::make('method')
                    ->label('Método')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'transferencia' => 'Transferência',
                        'multicaixa' => 'Multicaixa',
                        default => $state,
                    }),
                TextColumn::make('reference')
                    ->label('Referência')
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'warning',
                        'pago' => 'success',
                        'cancelado' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('paid_at')
                    ->label('Pago em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->label('Registado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pendente' => 'Pendente',
                        'pago' => 'Pago',
                        'cancelado' => 'Cancelado',
                    ]),
                SelectFilter::make('method')
                    ->label('Método')
                    ->options([
                        'transferencia' => 'Transferência',
                        'multicaixa' => 'Multicaixa',
                    ]),
            ])
            ->recordActions([
                Action::make('markAsPaid')
                    ->label('Marcar como Pago')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar Pagamento')
                    ->modalDescription('Confirma que este pagamento foi efectuado?')
                    ->modalSubmitActionLabel('Sim, confirmar')
                    ->visible(fn (Payment $record): bool => $record->status === 'pendente')
                    ->action(function (Payment $record, ProcessPaymentApproval $action): void {
                        $action->execute($record);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
