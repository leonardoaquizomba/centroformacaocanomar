<?php

namespace App\Filament\Resources\Enrollments\Tables;

use App\Models\Enrollment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.name')
                    ->label('Curso')
                    ->searchable(),
                TextColumn::make('courseClass.name')
                    ->label('Turma')
                    ->placeholder('Sem turma'),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'warning',
                        'aprovado' => 'info',
                        'matriculado' => 'success',
                        'concluído' => 'success',
                        'rejeitado' => 'danger',
                        'cancelado' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('approved_at')
                    ->label('Aprovado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->label('Inscrito em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pendente' => 'Pendente',
                        'aprovado' => 'Aprovado',
                        'rejeitado' => 'Rejeitado',
                        'matriculado' => 'Matriculado',
                        'concluído' => 'Concluído',
                        'cancelado' => 'Cancelado',
                    ]),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Aprovar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Aprovar Inscrição')
                    ->modalDescription('Tem a certeza que deseja aprovar esta inscrição?')
                    ->modalSubmitActionLabel('Sim, aprovar')
                    ->visible(fn (Enrollment $record): bool => $record->status === 'pendente')
                    ->action(function (Enrollment $record): void {
                        $record->update([
                            'status' => 'aprovado',
                            'approved_at' => now(),
                            'approved_by' => Auth::id(),
                        ]);
                    }),
                Action::make('reject')
                    ->label('Rejeitar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Rejeitar Inscrição')
                    ->modalDescription('Tem a certeza que deseja rejeitar esta inscrição?')
                    ->modalSubmitActionLabel('Sim, rejeitar')
                    ->visible(fn (Enrollment $record): bool => $record->status === 'pendente')
                    ->action(fn (Enrollment $record) => $record->update(['status' => 'rejeitado'])),
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
