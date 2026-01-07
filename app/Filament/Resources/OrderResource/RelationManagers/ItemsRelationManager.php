<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
    return $table
        ->recordTitleAttribute('menu_item_name')
        ->columns([
            Tables\Columns\TextColumn::make('menu_item_name')
                ->label('Dish'),
                
            Tables\Columns\TextColumn::make('quantity')
                ->label('Qty'),
                
            Tables\Columns\TextColumn::make('price')
                ->money('MYR'),
        ]);
    }
}
