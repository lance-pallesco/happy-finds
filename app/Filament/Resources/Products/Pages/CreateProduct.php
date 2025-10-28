<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\ProductImage;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Collection;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->images = $data['images'] ?? [];
        unset($data['images']);
        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->images)) {
            $this->saveProductImages($this->record, collect($this->images));
        }
    }

    private function saveProductImages($product, Collection $images): void
    {
        foreach ($images as $index => $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'is_primary' => $index === 0, // first uploaded = primary
            ]);
        }
    }
}
