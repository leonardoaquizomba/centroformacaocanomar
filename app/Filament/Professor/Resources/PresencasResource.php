<?php

namespace App\Filament\Professor\Resources;

use App\Enums\AttendanceStatus;
use App\Enums\EnrollmentStatus;
use App\Filament\Professor\Resources\PresencasResource\Pages\CreatePresenca;
use App\Filament\Professor\Resources\PresencasResource\Pages\EditPresenca;
use App\Filament\Professor\Resources\PresencasResource\Pages\ListPresencas;
use App\Models\Attendance;
use App\Models\CourseClass;
use App\Models\Enrollment;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class PresencasResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Presenças';

    protected static ?string $modelLabel = 'Presença';

    protected static ?string $pluralModelLabel = 'Registo de Presenças';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('courseClass', fn (Builder $q) => $q->where('teacher_id', Auth::id()));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Registo de Presença')
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
                    Select::make('user_id')
                        ->label('Aluno')
                        ->options(fn ($get) => Enrollment::query()
                            ->where('course_class_id', $get('course_class_id'))
                            ->whereIn('status', [EnrollmentStatus::Matriculado, EnrollmentStatus::Aprovado])
                            ->with('user')
                            ->get()
                            ->pluck('user.name', 'user_id'))
                        ->required()
                        ->searchable()
                        ->disabled(fn ($get): bool => blank($get('course_class_id')))
                        ->helperText(fn ($get): ?string => blank($get('course_class_id')) ? 'Seleccione primeiro a turma.' : null),
                    DatePicker::make('session_date')
                        ->label('Data da Sessão')
                        ->required()
                        ->displayFormat('d/m/Y'),
                    Select::make('status')
                        ->label('Estado')
                        ->options(AttendanceStatus::class)
                        ->required()
                        ->default(AttendanceStatus::Presente),
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
                    ->sortable()
                    ->searchable(),
                TextColumn::make('student.name')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('session_date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('course_class_id')
                    ->label('Turma')
                    ->options(fn () => CourseClass::query()
                        ->where('teacher_id', Auth::id())
                        ->pluck('name', 'id')),
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(AttendanceStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('session_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPresencas::route('/'),
            'create' => CreatePresenca::route('/create'),
            'edit' => EditPresenca::route('/{record}/edit'),
        ];
    }
}
