<?php

namespace App\Filament\Professor\Resources;

use App\Enums\EnrollmentStatus;
use App\Filament\Professor\Resources\NotasResource\Pages\CreateNota;
use App\Filament\Professor\Resources\NotasResource\Pages\EditNota;
use App\Filament\Professor\Resources\NotasResource\Pages\ListNotas;
use App\Models\CourseClass;
use App\Models\Enrollment;
use App\Models\Grade;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class NotasResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static ?string $navigationLabel = 'Notas';

    protected static ?string $modelLabel = 'Nota';

    protected static ?string $pluralModelLabel = 'Lançamento de Notas';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('teacher_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Avaliação')
                ->columns(2)
                ->schema([
                    Select::make('course_class_id')
                        ->label('Turma')
                        ->options(fn () => CourseClass::query()
                            ->where('teacher_id', Auth::id())
                            ->pluck('name', 'id'))
                        ->required()
                        ->live()
                        ->searchable(),
                    Select::make('enrollment_id')
                        ->label('Aluno')
                        ->options(fn ($get) => Enrollment::query()
                            ->where('course_class_id', $get('course_class_id'))
                            ->whereIn('status', [EnrollmentStatus::Matriculado, EnrollmentStatus::Aprovado, EnrollmentStatus::Concluido])
                            ->with('user')
                            ->get()
                            ->pluck('user.name', 'id'))
                        ->required()
                        ->searchable()
                        ->disabled(fn ($get): bool => blank($get('course_class_id')))
                        ->helperText(fn ($get): ?string => blank($get('course_class_id')) ? 'Seleccione primeiro a turma.' : null),
                    TextInput::make('name')
                        ->label('Avaliação')
                        ->required()
                        ->placeholder('Ex: Teste 1, Trabalho Prático'),
                    TextInput::make('score')
                        ->label('Nota Obtida')
                        ->numeric()
                        ->required()
                        ->minValue(0),
                    TextInput::make('max_score')
                        ->label('Nota Máxima')
                        ->numeric()
                        ->required()
                        ->default(20),
                    DateTimePicker::make('graded_at')
                        ->label('Data de Avaliação')
                        ->displayFormat('d/m/Y'),
                    Textarea::make('notes')
                        ->label('Observações')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('courseClass.name')
                    ->label('Turma')
                    ->sortable(),
                TextColumn::make('student.name')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Avaliação')
                    ->searchable(),
                TextColumn::make('score')
                    ->label('Nota')
                    ->numeric(decimalPlaces: 1)
                    ->suffix(fn (Grade $record): string => ' / '.number_format((float) $record->max_score, 1)),
                TextColumn::make('graded_at')
                    ->label('Data')
                    ->dateTime('d/m/Y')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('course_class_id')
                    ->label('Turma')
                    ->options(fn () => CourseClass::query()
                        ->where('teacher_id', Auth::id())
                        ->pluck('name', 'id')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('graded_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNotas::route('/'),
            'create' => CreateNota::route('/create'),
            'edit' => EditNota::route('/{record}/edit'),
        ];
    }
}
