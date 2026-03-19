<?php

namespace App\Filament\Aluno\Widgets;

use App\Enums\EnrollmentStatus;
use App\Models\Enrollment;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MinhasInscricoesWidget extends TableWidget
{
    protected static ?string $heading = 'As Minhas Inscrições';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Enrollment::query()
                    ->with(['course.category', 'courseClass'])
                    ->where('user_id', Auth::id())
            )
            ->columns([
                TextColumn::make('course.name')
                    ->label('Curso')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('course.category.name')
                    ->label('Categoria')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('courseClass.name')
                    ->label('Turma')
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->sortable(),

                TextColumn::make('course.duration_hours')
                    ->label('Duração')
                    ->suffix('h')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Inscrito em')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(EnrollmentStatus::class),
            ])
            ->recordActions([
                Action::make('details')
                    ->label('Detalhes')
                    ->icon(Heroicon::OutlinedInformationCircle)
                    ->modalHeading(fn (Enrollment $record): string => $record->course->name)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fechar')
                    ->infolist(fn (Enrollment $record): array => [
                        Section::make('Informações do Curso')
                            ->icon(Heroicon::OutlinedAcademicCap)
                            ->schema([
                                TextEntry::make('course.description')
                                    ->label('Descrição')
                                    ->columnSpanFull(),

                                TextEntry::make('course.modality')
                                    ->label('Modalidade')
                                    ->badge(),

                                TextEntry::make('course.level')
                                    ->label('Nível')
                                    ->badge(),

                                TextEntry::make('course.duration_hours')
                                    ->label('Duração')
                                    ->suffix(' horas'),

                                TextEntry::make('course.price')
                                    ->label('Preço')
                                    ->money('AOA'),

                                TextEntry::make('course.certification_type')
                                    ->label('Tipo de Certificação')
                                    ->placeholder('—'),
                            ])
                            ->columns(2),

                        Section::make('Detalhes da Inscrição')
                            ->icon(Heroicon::OutlinedClipboardDocumentList)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Estado')
                                    ->badge(),

                                TextEntry::make('courseClass.name')
                                    ->label('Turma')
                                    ->placeholder('—'),

                                TextEntry::make('courseClass.start_date')
                                    ->label('Início da Turma')
                                    ->date('d/m/Y')
                                    ->placeholder('—'),

                                TextEntry::make('courseClass.end_date')
                                    ->label('Fim da Turma')
                                    ->date('d/m/Y')
                                    ->placeholder('—'),

                                TextEntry::make('created_at')
                                    ->label('Data de Inscrição')
                                    ->dateTime('d/m/Y \à\s H:i'),

                                TextEntry::make('approved_at')
                                    ->label('Data de Aprovação')
                                    ->dateTime('d/m/Y \à\s H:i')
                                    ->placeholder('—')
                                    ->visible(fn (Enrollment $record): bool => $record->approved_at !== null),

                                TextEntry::make('notes')
                                    ->label('Observações')
                                    ->placeholder('—')
                                    ->columnSpanFull()
                                    ->visible(fn (Enrollment $record): bool => filled($record->notes)),

                                TextEntry::make('rejection_reason')
                                    ->label('Motivo de Rejeição')
                                    ->placeholder('—')
                                    ->color('danger')
                                    ->columnSpanFull()
                                    ->visible(fn (Enrollment $record): bool => $record->status === EnrollmentStatus::Rejeitado && filled($record->rejection_reason)),
                            ])
                            ->columns(2),
                    ]),
            ])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Ainda não tem inscrições')
            ->emptyStateDescription('As suas inscrições em cursos aparecerão aqui.')
            ->emptyStateIcon(Heroicon::OutlinedClipboardDocumentList);
    }
}
