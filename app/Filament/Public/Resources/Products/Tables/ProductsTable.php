<?php

namespace App\Filament\Public\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    ViewColumn::make('image')
                        ->alignCenter()
                        ->view('filament.infolists.components.product-card'),
                ]),
            ])  
            ->paginated(false)
            ->contentGrid([
                'md' => 2,
                'xl' => 5,
            ]);
    }
}
