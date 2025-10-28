<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\ProductImage;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Collection;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    public array $images = [];

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['images'] = $this->record->images()
            ->pluck('path')
            ->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->images = $data['images'] ?? [];
        unset($data['images']);

        return $data;
    }

    protected function afterSave(): void {
        $product = $this->record;

        $product->images()->delete();

        if(!empty($this->images)){
            $this->saveProductImages($product, collect($this->images));
        }
    }

    private function saveProductImages($product, Collection $images): void {
        foreach ($images as $index => $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'is_primary' => $index === 0,
            ]);
        }
    }
}
