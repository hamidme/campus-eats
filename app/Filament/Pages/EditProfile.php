<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. Name
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // 2. Email
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->maxLength(255),

                // 3. WhatsApp Phone (The new field we need!)
                TextInput::make('phone')
                    ->label('WhatsApp Number')
                    ->tel() // specific for phone numbers
                    ->required(),

                // 4. Password (Optional - only if they type to change it)
                TextInput::make('password')
                    ->password()
                    ->autocomplete('new-password')
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn ($livewire) => $livewire instanceof CreateRecord)
                    ->label('New Password (leave empty to keep current)'),
            ]);
    }

    protected function getRedirectUrl(): ?string
    {
        // Redirect to the main Admin Dashboard
        return filament()->getUrl(); 
    }
}