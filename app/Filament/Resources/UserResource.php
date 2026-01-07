<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash; // Import this!

class UserResource extends Resource
{
    public static function canViewAny(): bool
        {
            // Only 'admin' role can see this page
            return auth()->user()->role === 'admin';
        }

        // Also block direct URL access
        public static function canView($record): bool
        {
            return auth()->user()->role === 'admin';
        }

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

            Select::make('role')
                ->options([
                    'admin' => 'Admin',
                    'vendor' => 'Vendor',
                    'student' => 'Student',
                ])
                ->required()
                ->default('student'),

            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // Encrypt password
                ->dehydrated(fn ($state) => filled($state)) // Only update if typed
                ->required(fn (string $context): bool => $context === 'create'), // Required only on create
        ]);
    }

    public static function table(Table $table): Table
    {
    return $table
        ->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('role')
                ->badge() // Makes it look like a colorful tag
                ->color(fn (string $state): string => match ($state) {
                    'admin' => 'danger',
                    'vendor' => 'warning',
                    'student' => 'success',
                    default => 'gray',
                }),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
