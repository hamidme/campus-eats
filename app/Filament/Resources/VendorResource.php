<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        // Only Admins and Vendors can see this list
        // (Double protection: Students shouldn't be here anyway)
        return auth()->user()->role === 'admin' || auth()->user()->role === 'vendor';
    }

    public static function canCreate(): bool
    {
        // Only Admin can create new Kitchens
        return auth()->user()->role === 'admin';
    }

    public static function canDelete($record): bool
    {
        // Only Admin can delete Kitchens
        return auth()->user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            // Select which User owns this kitchen (Only useful for Admin)
            Select::make('user_id')
                ->relationship('user', 'name')
                ->label('Owner (User)')
                ->required()
                ->searchable()
                ->disabled(fn () => auth()->user()->role !== 'admin'), // Only Admin can change owner

            TextInput::make('kitchen_name')
                ->required()
                ->maxLength(255),

            Textarea::make('location_details')
                ->required()
                ->label('Pickup Location')
                ->placeholder('e.g., Block A, Level 1, near the cafe'),

            Select::make('status')
                ->options([
                    'active' => 'Active (Open)',
                    'closed' => 'Closed',
                ])
                ->default('active')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
    return $table
        ->columns([
            TextColumn::make('kitchen_name')->sortable()->searchable(),
            
            TextColumn::make('user.name')
                ->label('Owner')
                ->searchable(),
                
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'closed' => 'danger',
                }),
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
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
    $query = parent::getEloquentQuery();
    $user = auth()->user();

    // If Vendor: Show ONLY their own kitchen
    if ($user->role === 'vendor') {
        return $query->where('user_id', $user->id);
    }

    // If Admin: Show everything
    return $query;
    }
}
