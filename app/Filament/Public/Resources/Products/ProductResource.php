<?php

namespace App\Filament\Public\Resources\Products;

use App\Filament\Public\Resources\Products\Pages\ListProducts;
use App\Filament\Public\Resources\Products\Pages\ViewProduct;   
use App\Filament\Public\Resources\Products\Schemas\ProductInfolist;
use App\Filament\Public\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $recordTitleAttribute = 'name';

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
            'view' => ViewProduct::route('/{record}'),
        ];
    }

     public static function getEloquentQuery(): Builder
    {
        // Show only available/active products publicly
        return Product::query()
            ->whereIn('status', ['available' , 'out_of_stock']);
    }
}
