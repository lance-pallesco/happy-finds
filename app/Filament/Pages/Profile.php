<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\EditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class Profile extends EditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Personal Information')
                ->description('Basic personal details of your account.')
                ->schema([
                    Grid::make(1)->schema([
                        FileUpload::make('avatar')->avatar()
                                ->imageEditor()
                                ->disk('public')
                                ->visibility('public')
                                ->circleCropper()
                                ->image(),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getCurrentPasswordFormComponent(),
                ]),
            ]),
            Section::make('Contact Details')
                ->description('Contact information details of the account')
                ->relationship('socialMediaDetail')
                ->schema([
                    Grid::make(1)->schema([
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->placeholder('e.g., +639 12 542 0454')
                            ->tel(),
                        TextInput::make('whatsapp')
                            ->label('Whatsapp')
                            ->tel(),
                        TextInput::make('viber')
                            ->label('Viber')
                            ->tel(),
                        TextInput::make('instagram')
                            ->label('Instagram')
                    ])
                ])
        ]);
    }

    protected function getPasswordConfirmationFormComponent(): Component {
        return parent::getPasswordConfirmationFormComponent()
            ->rules([
                Password::min(8)
                    ->max(255)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->letters()
                    ->uncompromised(),
        ]);
    }
}
