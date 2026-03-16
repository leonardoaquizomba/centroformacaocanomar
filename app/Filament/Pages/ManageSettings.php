<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Definições do Site';

    protected static string|UnitEnum|null $navigationGroup = 'Configurações';

    protected static ?int $navigationSort = 90;

    protected string $view = 'filament-panels::pages.page';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::get()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Informações de Contacto')
                    ->description('Dados de contacto exibidos no site e no rodapé.')
                    ->schema([
                        TextInput::make('address')
                            ->label('Morada')
                            ->placeholder('Rua Principal, nº 123, Luanda')
                            ->columnSpanFull(),

                        TextInput::make('phone')
                            ->label('Telefone')
                            ->placeholder('+244 900 000 000')
                            ->tel(),

                        TextInput::make('email')
                            ->label('Email Geral')
                            ->placeholder('geral@canomar.ao')
                            ->email(),

                        TextInput::make('support_email')
                            ->label('Email de Suporte')
                            ->placeholder('suporte@canomar.ao')
                            ->email(),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp (número)')
                            ->placeholder('244900000000')
                            ->helperText('Apenas dígitos, sem espaços ou símbolos. Ex: 244912345678'),
                    ])
                    ->columns(2),

                Section::make('Redes Sociais')
                    ->description('URLs completos para as páginas das redes sociais.')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->placeholder('https://facebook.com/canomar')
                            ->url(),

                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->placeholder('https://instagram.com/canomar')
                            ->url(),

                        TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->placeholder('https://linkedin.com/company/canomar')
                            ->url(),

                        TextInput::make('youtube_url')
                            ->label('YouTube')
                            ->placeholder('https://youtube.com/@canomar')
                            ->url(),

                        TextInput::make('tiktok_url')
                            ->label('TikTok')
                            ->placeholder('https://tiktok.com/@canomar')
                            ->url(),
                    ])
                    ->columns(2),
            ]);
    }

    public function save(): void
    {
        $settings = SiteSetting::get();
        $settings->fill($this->form->getState())->save();

        Notification::make()
            ->success()
            ->title('Definições guardadas com sucesso.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Guardar Definições')
                ->action('save'),
        ];
    }
}
