<?php

namespace App\Filament\Professor\Resources;

use App\Filament\Professor\Resources\MateriaisUploadResource\Pages\CreateMaterial;
use App\Filament\Professor\Resources\MateriaisUploadResource\Pages\EditMaterial;
use App\Filament\Professor\Resources\MateriaisUploadResource\Pages\ListMateriais;
use App\Models\CourseClass;
use App\Models\CourseMaterial;
use BackedEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MateriaisUploadResource extends Resource
{
    protected static ?string $model = CourseMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;

    protected static ?string $navigationLabel = 'Materiais';

    protected static ?string $modelLabel = 'Material';

    protected static ?string $pluralModelLabel = 'Upload de Materiais';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Material de Apoio')
                ->schema([
                    Select::make('course_class_id')
                        ->label('Turma')
                        ->options(
                            CourseClass::query()
                                ->where('teacher_id', Auth::id())
                                ->pluck('name', 'id')
                        )
                        ->required()
                        ->searchable(),
                    TextInput::make('title')
                        ->label('Título')
                        ->required(),
                    Textarea::make('description')
                        ->label('Descrição'),
                    FileUpload::make('file_path')
                        ->label('Ficheiro')
                        ->required()
                        ->disk('private')
                        ->directory('materials')
                        ->storeFileNamesIn('original_name')
                        ->acceptedFileTypes(['application/pdf', 'video/mp4', 'application/zip', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                TextColumn::make('courseClass.name')
                    ->label('Turma')
                    ->sortable(),
                TextColumn::make('original_name')
                    ->label('Ficheiro'),
                TextColumn::make('created_at')
                    ->label('Carregado em')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMateriais::route('/'),
            'create' => CreateMaterial::route('/create'),
            'edit' => EditMaterial::route('/{record}/edit'),
        ];
    }
}
