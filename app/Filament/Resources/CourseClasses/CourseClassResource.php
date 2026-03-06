<?php

namespace App\Filament\Resources\CourseClasses;

use App\Filament\Resources\CourseClasses\Pages\CreateCourseClass;
use App\Filament\Resources\CourseClasses\Pages\EditCourseClass;
use App\Filament\Resources\CourseClasses\Pages\ListCourseClasses;
use App\Filament\Resources\CourseClasses\Schemas\CourseClassForm;
use App\Filament\Resources\CourseClasses\Tables\CourseClassesTable;
use App\Models\CourseClass;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CourseClassResource extends Resource
{
    protected static ?string $model = CourseClass::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Turmas';

    protected static ?string $modelLabel = 'Turma';

    protected static ?string $pluralModelLabel = 'Turmas';

    protected static string|UnitEnum|null $navigationGroup = 'Cursos';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CourseClassForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseClassesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseClasses::route('/'),
            'create' => CreateCourseClass::route('/create'),
            'edit' => EditCourseClass::route('/{record}/edit'),
        ];
    }
}
