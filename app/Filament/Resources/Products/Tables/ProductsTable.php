<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->contentGrid([
                'sm' => 2,
                'md' => 3, // 3 cards per row on medium screens
                'xl' => 4, // 4 cards on large screens
            ])
            ->columns([
                ViewColumn::make('card')
                    ->view('filament.infolists.components.product-card'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View')
                    ->button()
                    ->outlined()
                    ->color('gray')
                    ->extraAttributes(['class' => 'mt-3 text-sm w-full text-center']),
                EditAction::make()
                    ->label('Edit')
                    ->button()
                    ->color('primary')
                    ->extraAttributes(['class' => 'mt-2 text-sm w-full text-center']),
            ]);
    }
}
