<?php

namespace App\Filament\Resources\Newsletter;

use App\Filament\Resources\Newsletter\Pages\ListNewsletterSubscribers;
use App\Filament\Resources\Newsletter\Tables\NewsletterSubscribersTable;
use App\Models\NewsletterSubscriber;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NewsletterSubscriberResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelopeOpen;

    protected static ?string $navigationLabel = 'Newsletter';

    protected static ?string $modelLabel = 'Subscrito';

    protected static ?string $pluralModelLabel = 'Subscritos da Newsletter';

    protected static string|UnitEnum|null $navigationGroup = 'Conteúdo';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return NewsletterSubscribersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNewsletterSubscribers::route('/'),
        ];
    }
}
