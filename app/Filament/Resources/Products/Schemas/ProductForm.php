<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Details')
                ->description('Enter the main details of your product below.')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->label('Product Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Summer Floral Dress'),

                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->prefix('₱')
                            ->required()
                            ->placeholder('e.g. 999.00'),
                    ]),

                    Textarea::make('description')
                        ->label('Description')
                        ->rows(4)
                        ->placeholder('Write a short description or highlight key features...')
                        ->required()
                        ->columnSpanFull(),

                    Grid::make(2)->schema([
                        TextInput::make('category')
                            ->label('Category')
                            ->placeholder('e.g. Clothing, Accessories, Shoes...'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'available' => 'Available',
                                'inactive' => 'Inactive',
                                'out_of_stock' => 'Out of Stock',
                                'archived' => 'Archived',
                            ])
                            ->default('active')
                            ->required(),
                    ]),
                ])
                ->collapsible()
                ->columns(1),

            Section::make('Product Images')
                ->description('Upload high-quality product photos. You can upload multiple images per product.')
                ->schema([
                    FileUpload::make('images')
                        ->label('Upload Images')
                        ->multiple()
                        ->reorderable()
                        ->image()
                        ->imageEditor()
                        ->panelLayout('grid') 
                        ->disk('public')
                        ->directory('products')
                        ->visibility('public')
                        ->preserveFilenames()
                        ->hint('The first image will be the primary image')
                        ->imagePreviewHeight('100px') // make the preview smaller
                ])
                ->collapsible(),
            ]);
    }
}
