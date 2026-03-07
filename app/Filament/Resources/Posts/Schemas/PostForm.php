<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\PostCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Conteúdo')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('post_category_id')
                            ->label('Categoria')
                            ->options(PostCategory::pluck('name', 'id'))
                            ->nullable()
                            ->searchable(),
                        FileUpload::make('image')
                            ->label('Imagem de Capa')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->directory('posts'),
                        Textarea::make('excerpt')
                            ->label('Resumo')
                            ->columnSpanFull()
                            ->rows(2),
                        RichEditor::make('body')
                            ->label('Conteúdo')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Publicação')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publicado')
                            ->live()
                            ->afterStateUpdated(function (bool $state, callable $set): void {
                                if ($state) {
                                    $set('published_at', now());
                                }
                            }),
                        DateTimePicker::make('published_at')
                            ->label('Data de Publicação')
                            ->displayFormat('d/m/Y H:i'),
                    ]),
            ]);
    }
}
