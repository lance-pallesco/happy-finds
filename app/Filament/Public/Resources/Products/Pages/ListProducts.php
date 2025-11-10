<?php

namespace App\Filament\Public\Resources\Products\Pages;

use App\Filament\Public\Resources\Products\ProductResource;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
    
    public function getTitle(): string {
         return 'Product Catalog';
    }
}
