<?php

namespace App\Filament\Aluno\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class EditStudentProfile extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $navigationLabel = 'O Meu Perfil';

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament-panels::pages.page';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        $profile = $user->studentProfile;

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'bi_number' => $profile?->bi_number,
            'date_of_birth' => $profile?->date_of_birth?->format('Y-m-d'),
            'address' => $profile?->address,
            'phone' => $profile?->phone,
            'photo_path' => $profile?->photo_path,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Dados da Conta')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email')
                            ->disabled(),
                    ])
                    ->columns(2),

                Section::make('Dados Pessoais')
                    ->schema([
                        FileUpload::make('photo_path')
                            ->label('Foto de Perfil')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->disk('public')
                            ->directory('student-photos')
                            ->avatar()
                            ->nullable()
                            ->columnSpanFull(),
                        TextInput::make('bi_number')
                            ->label('Número do BI')
                            ->maxLength(20)
                            ->nullable(),
                        DatePicker::make('date_of_birth')
                            ->label('Data de Nascimento')
                            ->nullable(),
                        TextInput::make('phone')
                            ->label('Telefone')
                            ->tel()
                            ->maxLength(20)
                            ->nullable(),
                        Textarea::make('address')
                            ->label('Morada')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = Auth::user();

        $user->studentProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bi_number' => $data['bi_number'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'address' => $data['address'] ?? null,
                'phone' => $data['phone'] ?? null,
                'photo_path' => $data['photo_path'] ?? null,
            ]
        );

        Notification::make()
            ->success()
            ->title('Perfil actualizado com sucesso.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Guardar')
                ->action('save'),
        ];
    }
}
