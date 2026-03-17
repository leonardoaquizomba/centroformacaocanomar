<?php

namespace App\Filament\Resources\Enrollments\Tables;

use App\Enums\EnrollmentStatus;
use App\Events\EnrollmentApproved;
use App\Events\EnrollmentRejected;
use App\Filament\Exports\EnrollmentExporter;
use App\Models\Enrollment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Forms\Components\Textarea;
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
                    ->badge(),
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
                    ->options(EnrollmentStatus::class),
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
                    ->visible(fn (Enrollment $record): bool => $record->status === EnrollmentStatus::Pendente)
                    ->action(function (Enrollment $record): void {
                        $record->update([
                            'status' => EnrollmentStatus::Aprovado,
                            'approved_at' => now(),
                            'approved_by' => Auth::id(),
                        ]);
                        EnrollmentApproved::dispatch($record->load(['user', 'course', 'courseClass']));
                    }),
                Action::make('reject')
                    ->label('Rejeitar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Motivo da rejeição')
                            ->required()
                            ->rows(3)
                            ->maxLength(500),
                    ])
                    ->modalHeading('Rejeitar Inscrição')
                    ->modalSubmitActionLabel('Rejeitar')
                    ->visible(fn (Enrollment $record): bool => $record->status === EnrollmentStatus::Pendente)
                    ->action(function (Enrollment $record, array $data): void {
                        $record->update([
                            'status' => EnrollmentStatus::Rejeitado,
                            'rejection_reason' => $data['rejection_reason'],
                        ]);
                        EnrollmentRejected::dispatch($record->load(['user', 'course', 'courseClass']));
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->exporter(EnrollmentExporter::class)->label('Exportar selecionados'),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
