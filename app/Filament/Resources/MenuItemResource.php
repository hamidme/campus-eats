<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Auth;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // 1. Get the standard list
        $query = parent::getEloquentQuery();

        // 2. Who is logged in?
        $user = auth()->user();

        // 3. If it is a "Vendor", ONLY show their own food
        if ($user->role === 'vendor') {
            // Safety check: Does this user actually have a vendor profile?
            if ($user->vendor) {
                return $query->where('vendor_id', $user->vendor->id);
            }
        }

        // 4. If Admin, show everything
        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('price')
                    ->numeric()
                    ->prefix('RM')
                    ->required(),

                // SCENARIO 1: ADMIN IS LOGGED IN
                // Show a searchable dropdown.
                Select::make('vendor_id')
                    ->label('Kitchen / Vendor')
                    ->relationship('vendor', 'kitchen_name')
                    // 'searchable()' turns the dropdown into a search box. 
                    // Solves your concern about long lists!
                    ->searchable()
                    ->preload()
                    ->required()
                    // Only show this to Admin
                    ->visible(fn () => Auth::user()->role === 'admin'),

                Textarea::make('description')
                    ->columnSpanFull(),

                FileUpload::make('image_path')
                    ->directory('food-images')
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->label('Photo'),
                
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('price')
                    ->money('MYR')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}