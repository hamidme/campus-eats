<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            Select::make('user_id')
                ->relationship('user', 'name')
                ->disabled() // Can't change who ordered it
                ->label('Customer'),

            TextInput::make('total_amount')
                ->prefix('RM')
                ->disabled(),

            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'preparing' => 'Preparing',
                    'ready' => 'Ready for Pickup',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
    return $table
        ->columns([
            TextColumn::make('id')
                ->label('Order ID')
                ->sortable()
                ->searchable(),

            // Display the User's name through the relationship
            TextColumn::make('user.name')
                ->label('Customer')
                ->searchable(),

            TextColumn::make('total_amount')
                ->money('MYR')
                ->sortable(),

            // Allow Vendors to change status directly in the table!
            SelectColumn::make('status')
                ->options([
                    'pending' => 'Pending',
                    'preparing' => 'Preparing',
                    'ready' => 'Ready for Pickup',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ])
                ->sortable(),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->label('Ordered At'),
        ])
        ->defaultSort('created_at', 'desc') // Newest orders first
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
            // This registers the file we created in Step 1
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Get the standard query
        $query = parent::getEloquentQuery();

        // Check who is logged in
        $user = auth()->user();

        // If it is a VENDOR, put blinders on them
        if (strtolower($user->role) === 'vendor' && $user->vendor) {
            $query->where('vendor_id', $user->vendor->id);
        }

        return $query;
    }
}
